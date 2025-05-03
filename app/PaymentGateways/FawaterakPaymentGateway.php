<?php

namespace App\PaymentGateways;

use App\Models\Donation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FawaterakPaymentGateway extends AbstractPaymentGateway
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $mode;
    protected array $redirectUrls;

    /**
     * FawaterakPaymentGateway constructor.
     */
    public function __construct()
    {
        $this->mode = config('payment.fawaterak.mode', 'sandbox');
        $this->apiKey = config('payment.fawaterak.api_key');
        $this->baseUrl = $this->mode === 'live' 
            ? 'https://app.fawaterk.com/api/v2' 
            : 'https://staging.fawaterk.com/api/v2';
        
        $baseUrl = config('app.url');
        $this->redirectUrls = [
            'successUrl' => $baseUrl . '/payments/success',
            'failUrl' => $baseUrl . '/payments/fail',
            'pendingUrl' => $baseUrl . '/payments/pending',
            'webhookUrl' => $baseUrl . '/api/payments/webhook/fawaterak',
        ];
    }

    /**
     * Get payment gateway name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Fawaterak';
    }

    /**
     * Get available payment methods for Fawaterak
     *
     * @return array
     */
    public function getPaymentMethods(): array
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/getPaymentmethods');

            if ($response->successful() && $response->json('status') === 'success') {
                return $response->json('data', []);
            }

            $this->log('Failed to get payment methods', [
                'response' => $response->json(),
            ]);

            return [];
        } catch (\Exception $e) {
            $this->log('Error getting payment methods', [
                'error' => $e->getMessage(),
            ]);
            
            return [];
        }
    }

    /**
     * Initialize a payment transaction
     *
     * @param Donation $donation
     * @param array $data Extra parameters for the payment request
     * @return array
     */
    public function initializePayment(Donation $donation, array $data = []): array
    {
        try {
            $paymentMethodId = $data['payment_method_id'] ?? null;
            
            if (!$paymentMethodId) {
                return [
                    'success' => false,
                    'message' => $this->trans('payment_method_required'),
                ];
            }

            $campaign = $donation->campaign;
            $donor = $donation->donor;
            
            // Format donor name parts
            $nameParts = explode(' ', $donor->name);
            $firstName = $nameParts[0] ?? 'Donor';
            $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : 'User';

            // Prepare cart items
            $cartItems = [
                [
                    'name' => $campaign ? $campaign->name : $this->trans('donation'),
                    'price' => (string) $donation->amount,
                    'quantity' => '1',
                ],
            ];

            // Prepare request payload
            $payload = [
                'payment_method_id' => (int) $paymentMethodId,
                'cartTotal' => (string) $donation->amount,
                'currency' => $donation->currency ?? 'EGP',
                'invoice_number' => 'DON-' . $donation->id,
                'customer' => [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $donor->email ?? '',
                    'phone' => $donor->phone ?? '',
                    'address' => $donor->address ?? '',
                ],
                'redirectionUrls' => $this->redirectUrls,
                'cartItems' => $cartItems,
                'payLoad' => [
                    'donation_id' => $donation->id,
                    'campaign_id' => $campaign ? $campaign->id : null,
                ],
            ];

            // Log the request
            $this->log('Initializing payment', [
                'donation_id' => $donation->id,
                'payload' => $payload,
            ]);

            // Send request to Fawaterak
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->post($this->baseUrl . '/invoiceInitPay', $payload);

            if ($response->successful() && $response->json('status') === 'success') {
                $responseData = $response->json('data');
                
                // Update donation with payment information
                $donation->update([
                    'invoice_id' => $responseData['invoice_id'] ?? null,
                    'invoice_key' => $responseData['invoice_key'] ?? null,
                    'payment_method' => $this->getPaymentMethodName($paymentMethodId),
                    'payment_status' => 'pending',
                    'payment_data' => $responseData['payment_data'] ?? [],
                ]);

                return [
                    'success' => true,
                    'message' => $this->trans('payment_initialized'),
                    'data' => $responseData,
                ];
            }

            $this->log('Payment initialization failed', [
                'donation_id' => $donation->id,
                'response' => $response->json(),
            ]);

            return [
                'success' => false,
                'message' => $this->trans('payment_initialization_failed'),
                'error' => $response->json('message', $this->trans('unknown_error')),
            ];
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Process webhook notification from Fawaterak
     *
     * @param array $data Webhook data
     * @return array
     */
    public function processWebhook(array $data): array
    {
        $this->log('Processing webhook', [
            'webhook_data' => $data,
        ]);

        try {
            // Verify webhook data
            if (!$this->verifyWebhookData($data)) {
                return [
                    'success' => false,
                    'message' => $this->trans('invalid_webhook_data'),
                ];
            }

            $invoiceKey = $data['invoice_key'] ?? null;
            $invoiceStatus = $data['invoice_status'] ?? null;

            if (!$invoiceKey || !$invoiceStatus) {
                return [
                    'success' => false,
                    'message' => $this->trans('missing_required_fields'),
                ];
            }

            // Find the donation by invoice key
            $donation = Donation::where('invoice_key', $invoiceKey)->first();

            if (!$donation) {
                return [
                    'success' => false,
                    'message' => $this->trans('donation_not_found'),
                ];
            }

            // Update donation status based on the webhook
            $status = strtolower($invoiceStatus);
            $paymentStatus = 'pending';

            if ($status === 'paid') {
                $paymentStatus = 'success';
                
                // Update campaign collected amount if payment is successful
                if ($donation->campaign) {
                    $donation->campaign->increment('collected_amount', $donation->amount);
                }
            } elseif (in_array($status, ['failed', 'expired', 'cancelled'])) {
                $paymentStatus = 'failed';
            }

            // Update donation payment status
            $donation->update([
                'payment_status' => $paymentStatus,
                'paid_at' => $paymentStatus === 'success' ? now() : null,
                'payment_reference' => $data['referenceNumber'] ?? null,
            ]);

            return [
                'success' => true,
                'message' => $this->trans('webhook_processed'),
                'donation_id' => $donation->id,
                'payment_status' => $paymentStatus,
            ];
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Verify payment status
     *
     * @param string $paymentId Invoice ID or key
     * @return array
     */
    public function verifyPayment(string $paymentId): array
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/getInvoiceData/' . $paymentId);

            if ($response->successful() && $response->json('status') === 'success') {
                $responseData = $response->json('data');
                
                return [
                    'success' => true,
                    'data' => $responseData,
                    'is_paid' => ($responseData['paid'] ?? 0) == 1,
                    'payment_status' => ($responseData['paid'] ?? 0) == 1 ? 'success' : 'pending',
                ];
            }

            $this->log('Payment verification failed', [
                'payment_id' => $paymentId,
                'response' => $response->json(),
            ]);

            return [
                'success' => false,
                'message' => $this->trans('payment_verification_failed'),
                'error' => $response->json('message', $this->trans('unknown_error')),
            ];
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Verify webhook data hash
     *
     * @param array $data
     * @return bool
     */
    protected function verifyWebhookData(array $data): bool
    {
        // If using the new webhook format with hash key
        if (isset($data['hashKey'])) {
            $secretKey = config('payment.fawaterak.vendor_key');
            $queryParam = "InvoiceId={$data['invoice_id']}&InvoiceKey={$data['invoice_key']}&PaymentMethod={$data['payment_method']}";
            $calculatedHash = hash_hmac('sha256', $queryParam, $secretKey, false);
            
            return $calculatedHash === $data['hashKey'];
        }
        
        // For old webhook format, just verify essential fields
        return isset($data['invoice_key']) && isset($data['invoice_status']);
    }

    /**
     * Get payment method name by ID
     *
     * @param int $methodId
     * @return string
     */
    protected function getPaymentMethodName(int $methodId): string
    {
        $methods = [
            2 => 'Credit Card',
            3 => 'Fawry',
            4 => 'Meeza',
        ];

        return $methods[$methodId] ?? 'Unknown';
    }
}
