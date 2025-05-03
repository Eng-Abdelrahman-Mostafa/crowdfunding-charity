<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use App\PaymentGateways\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * @var PaymentGatewayInterface
     */
    protected PaymentGatewayInterface $gateway;

    /**
     * PaymentService constructor.
     *
     * @param PaymentGatewayInterface $gateway
     */
    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Get available payment methods
     *
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return $this->gateway->getPaymentMethods();
    }

    /**
     * Create a donation and initialize payment
     *
     * @param array $data
     * @param User $donor
     * @return array
     */
    public function createDonation(array $data, User $donor): array
    {
        try {
            // Get campaign
            $campaign = Campaign::findOrFail($data['campaign_id']);

            // Create donation record
            $donation = Donation::create([
                'donor_id' => $donor->id,
                'campaign_id' => $campaign->id,
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'EGP',
                'donate_anonymously' => $data['donate_anonymously'] ?? false,
                'payment_status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'online',
                'due_date' => now()->addDay(),
            ]);

            // Initialize payment with gateway
            $result = $this->gateway->initializePayment($donation, $data);

            if (!$result['success']) {
                // If payment initialization failed, mark donation as failed
                $donation->update(['payment_status' => 'failed']);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Error creating donation: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => trans('payment.donation_creation_failed'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process webhook notification from payment gateway
     *
     * @param array $data
     * @param string|null $gateway
     * @return array
     */
    public function processWebhook(array $data, ?string $gateway = null): array
    {
        return $this->gateway->processWebhook($data);
    }

    /**
     * Verify payment status
     *
     * @param string $paymentId
     * @return array
     */
    public function verifyPayment(string $paymentId): array
    {
        return $this->gateway->verifyPayment($paymentId);
    }

    /**
     * Update donation status and handle related logic
     *
     * @param Donation $donation
     * @param string $status
     * @return Donation
     */
    public function updateDonationStatus(Donation $donation, string $status): Donation
    {
        // Update donation status
        $donation->update([
            'payment_status' => $status,
            'paid_at' => $status === 'success' ? now() : null,
        ]);

        // If payment is successful, update campaign collected amount
        if ($status === 'success' && $donation->campaign) {
            $donation->campaign->increment('collected_amount', $donation->amount);
        }

        return $donation;
    }
}