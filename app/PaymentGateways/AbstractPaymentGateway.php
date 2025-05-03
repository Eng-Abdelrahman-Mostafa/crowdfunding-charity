<?php

namespace App\PaymentGateways;

use App\Models\Donation;
use App\PaymentGateways\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

abstract class AbstractPaymentGateway implements PaymentGatewayInterface
{
    /**
     * Get the translated message based on the current locale
     *
     * @param string $key
     * @param array $replace
     * @return string
     */
    protected function trans(string $key, array $replace = []): string
    {
        return trans('payment.' . $key, $replace);
    }

    /**
     * Log payment gateway activity
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    protected function log(string $message, array $context = []): void
    {
        Log::channel('payment')->info(
            $this->getName() . ': ' . $message,
            $context
        );
    }

    /**
     * Handle common error cases and return standardized response
     *
     * @param \Exception $e
     * @return array
     */
    protected function handleException(\Exception $e): array
    {
        $this->log('Error: ' . $e->getMessage(), [
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return [
            'success' => false,
            'message' => $this->trans('error_occurred'),
            'error' => $e->getMessage(),
        ];
    }

    /**
     * Format donation data for payment gateway
     *
     * @param Donation $donation
     * @return array
     */
    protected function formatDonationData(Donation $donation): array
    {
        // Get donor information
        $donor = $donation->donor;

        return [
            'amount' => $donation->amount,
            'currency' => $donation->currency ?? 'EGP',
            'description' => $donation->campaign ? $donation->campaign->name : $this->trans('donation'),
            'customer' => [
                'first_name' => $donor->name ?? '',
                'last_name' => '',
                'email' => $donor->email ?? '',
                'phone' => $donor->phone ?? '',
            ],
        ];
    }

    /**
     * Update donation with payment details
     *
     * @param Donation $donation
     * @param array $paymentData
     * @return Donation
     */
    protected function updateDonation(Donation $donation, array $paymentData): Donation
    {
        $donation->update([
            'payment_id' => $paymentData['payment_id'] ?? null,
            'payment_status' => $paymentData['status'] ?? 'pending',
            'payment_data' => $paymentData,
        ]);

        return $donation;
    }
}
