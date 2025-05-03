<?php

namespace App\PaymentGateways\Contracts;

use App\Models\Donation;

interface PaymentGatewayInterface
{
    /**
     * Get payment gateway name
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Get available payment methods for the gateway
     * 
     * @return array
     */
    public function getPaymentMethods(): array;

    /**
     * Initialize a payment transaction
     * 
     * @param Donation $donation The donation record
     * @param array $data Extra parameters for the payment request
     * @return array Response with payment data
     */
    public function initializePayment(Donation $donation, array $data = []): array;

    /**
     * Process webhook notification from the payment gateway
     * 
     * @param array $data The webhook data
     * @return array Response data
     */
    public function processWebhook(array $data): array;

    /**
     * Verify payment status
     * 
     * @param string $paymentId The payment ID from the gateway
     * @return array Payment status details
     */
    public function verifyPayment(string $paymentId): array;
}
