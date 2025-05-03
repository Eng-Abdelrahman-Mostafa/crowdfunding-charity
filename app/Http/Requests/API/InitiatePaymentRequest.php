<?php

namespace App\Http\Requests\API;

use App\Models\Campaign;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InitiatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Any authenticated user can initiate payment
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'campaign_id' => ['required', 'exists:campaigns,id', function ($attribute, $value, $fail) {
                $campaign = Campaign::find($value);
                
                if (!$campaign) {
                    $fail(trans('payment.campaign_not_found'));
                    return;
                }
                
                if ($campaign->status !== 'active') {
                    $fail(trans('payment.inactive_campaign'));
                }
                
                if ($campaign->donation_type === 'share' && $this->input('amount') != $campaign->share_amount) {
                    $fail(trans('payment.invalid_share_amount', ['amount' => $campaign->share_amount]));
                }
                
                $remainingGoal = $campaign->goal_amount - $campaign->collected_amount;
                if ($this->input('amount') > $remainingGoal) {
                    $fail(trans('payment.amount_exceeds_remaining_goal', ['remaining' => $remainingGoal]));
                }
            }],
            'amount' => ['required', 'numeric', 'min:1'],
            'currency' => ['sometimes', 'string', 'size:3'],
            'payment_method_id' => ['required', 'integer'],
            'donate_anonymously' => ['sometimes', 'boolean'],
            'payment_method' => ['sometimes', Rule::in(['online', 'offline'])],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'campaign_id' => trans('payment.campaign'),
            'amount' => trans('payment.amount'),
            'currency' => trans('payment.currency'),
            'payment_method_id' => trans('payment.payment_method'),
            'donate_anonymously' => trans('payment.donate_anonymously'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'campaign_id.required' => trans('payment.campaign_required'),
            'campaign_id.exists' => trans('payment.campaign_not_found'),
            'amount.required' => trans('payment.amount_required'),
            'amount.numeric' => trans('payment.amount_numeric'),
            'amount.min' => trans('payment.amount_min'),
            'payment_method_id.required' => trans('payment.payment_method_required'),
            'payment_method_id.integer' => trans('payment.payment_method_invalid'),
        ];
    }
}
