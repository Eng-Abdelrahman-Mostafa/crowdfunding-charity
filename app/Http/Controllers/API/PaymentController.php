<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\InitiatePaymentRequest;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @var PaymentService
     */
    protected PaymentService $paymentService;

    /**
     * PaymentController constructor.
     *
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Get available payment methods
     * 
     * @LRDdescription Retrieve a list of available payment methods from the configured payment gateway.
     * @LRDresponses 200|422|500
     *
     * @return JsonResponse
     */
    public function getPaymentMethods(): JsonResponse
    {
        $paymentMethods = $this->paymentService->getPaymentMethods();

        return response()->json([
            'success' => true,
            'payment_methods' => $paymentMethods,
        ]);
    }

    /**
     * Initialize payment for donation
     * 
     * @LRDdescription Create a donation and initialize payment with the payment gateway.
     * @LRDparam campaign_id required|integer The ID of the campaign to donate to
     * @LRDparam amount required|numeric The donation amount
     * @LRDparam currency optional|string The currency code (default: EGP)
     * @LRDparam payment_method_id required|integer The payment method ID from getPaymentMethods
     * @LRDparam donate_anonymously optional|boolean Whether to donate anonymously (default: false)
     * @LRDparam payment_method optional|string Either 'online' or 'offline'
     * @LRDresponses 200|400|401|422|500
     *
     * @param InitiatePaymentRequest $request
     * @return JsonResponse
     */
    public function initiatePayment(InitiatePaymentRequest $request): JsonResponse
    {
        // Get authenticated user (donor)
        $donor = $request->user();
        
        // Create donation and initialize payment
        $result = $this->paymentService->createDonation($request->validated(), $donor);

        return response()->json($result);
    }

    /**
     * Handle payment webhook
     * 
     * @LRDdescription Process webhook notifications from payment gateways
     * @LRDparam invoice_key required|string The invoice key from the payment gateway
     * @LRDparam invoice_status required|string The payment status (paid, failed, etc.)
     * @LRDparam referenceNumber optional|string The reference number from the payment gateway
     * @LRDparam hashKey optional|string The hash key for validating the webhook
     * @LRDparam payment_method optional|string The payment method used
     * @LRDparam pay_load optional|object Additional data from the payment gateway
     * @LRDresponses 200|400|422|500
     *
     * @param Request $request
     * @param string|null $gateway
     * @return JsonResponse
     */
    public function webhook(Request $request, ?string $gateway = null): JsonResponse
    {
        $result = $this->paymentService->processWebhook($request->all(), $gateway);

        return response()->json($result);
    }

    /**
     * Verify payment status
     * 
     * @LRDdescription Check the status of a payment with the payment gateway
     * @LRDparam paymentId required|string The payment ID or invoice ID from the payment gateway
     * @LRDresponses 200|400|404|500
     *
     * @param string $paymentId
     * @return JsonResponse
     */
    public function verifyPayment(string $paymentId): JsonResponse
    {
        $result = $this->paymentService->verifyPayment($paymentId);

        return response()->json($result);
    }
}
