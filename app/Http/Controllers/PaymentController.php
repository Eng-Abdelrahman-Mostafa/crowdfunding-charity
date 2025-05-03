<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     * Handle successful payment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success(Request $request)
    {
        $invoiceKey = $request->get('invoice_key');
        
        if (!$invoiceKey) {
            return redirect()
                ->route('home')
                ->with('error', trans('payment.missing_invoice_key'));
        }
        
        $donation = Donation::where('invoice_key', $invoiceKey)->first();
        
        if (!$donation) {
            return redirect()
                ->route('home')
                ->with('error', trans('payment.donation_not_found'));
        }
        
        // If payment status is still pending, verify the payment
        if ($donation->payment_status === 'pending') {
            $result = $this->paymentService->verifyPayment($donation->invoice_id);
            
            if ($result['success'] && $result['is_paid']) {
                $this->paymentService->updateDonationStatus($donation, 'success');
            }
        }
        
        // Redirect to donation success page
        return redirect()
            ->route('donations.success', ['id' => $donation->id])
            ->with('success', trans('payment.payment_successful'));
    }

    /**
     * Handle failed payment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fail(Request $request)
    {
        $invoiceKey = $request->get('invoice_key');
        
        if (!$invoiceKey) {
            return redirect()
                ->route('home')
                ->with('error', trans('payment.missing_invoice_key'));
        }
        
        $donation = Donation::where('invoice_key', $invoiceKey)->first();
        
        if (!$donation) {
            return redirect()
                ->route('home')
                ->with('error', trans('payment.donation_not_found'));
        }
        
        // Update donation status to failed
        $donation->update([
            'payment_status' => 'failed',
        ]);
        
        // Redirect to donation failure page
        return redirect()
            ->route('campaigns.show', ['id' => $donation->campaign_id])
            ->with('error', trans('payment.payment_failed'));
    }

    /**
     * Handle pending payment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pending(Request $request)
    {
        $invoiceKey = $request->get('invoice_key');
        
        if (!$invoiceKey) {
            return redirect()
                ->route('home')
                ->with('error', trans('payment.missing_invoice_key'));
        }
        
        $donation = Donation::where('invoice_key', $invoiceKey)->first();
        
        if (!$donation) {
            return redirect()
                ->route('home')
                ->with('error', trans('payment.donation_not_found'));
        }
        
        // Redirect to pending payment page
        return redirect()
            ->route('campaigns.show', ['id' => $donation->campaign_id])
            ->with('info', trans('payment.payment_pending'));
    }
}
