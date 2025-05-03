<?php

return [
    // General
    'donation' => 'Donation',
    'error_occurred' => 'An error occurred while processing your payment.',
    'unknown_error' => 'An unknown error occurred.',
    
    // Payment info
    'campaign' => 'Campaign',
    'amount' => 'Amount',
    'currency' => 'Currency',
    'payment_method' => 'Payment Method',
    'donate_anonymously' => 'Donate Anonymously',
    
    // Payment initialization
    'payment_initialized' => 'Payment has been initialized successfully.',
    'payment_initialization_failed' => 'Failed to initialize payment.',
    'payment_method_required' => 'Payment method is required.',
    'campaign_required' => 'Campaign is required.',
    'campaign_not_found' => 'Campaign not found.',
    'inactive_campaign' => 'This campaign is not active.',
    'amount_required' => 'Amount is required.',
    'amount_numeric' => 'Amount must be a number.',
    'amount_min' => 'Amount must be at least 1.',
    'payment_method_invalid' => 'Invalid payment method.',
    'invalid_share_amount' => 'For this campaign, donation amount must be :amount.',
    'amount_exceeds_remaining_goal' => 'Donation amount exceeds the remaining goal amount (:remaining).',
    
    // Payment status
    'payment_successful' => 'Your payment has been successfully processed.',
    'payment_failed' => 'Your payment has failed. Please try again.',
    'payment_pending' => 'Your payment is pending. We will update you once it\'s processed.',
    'offline_donation_created' => 'Your offline donation has been recorded.',
    
    // Webhook processing
    'webhook_processed' => 'Webhook has been processed successfully.',
    'invalid_webhook_data' => 'Invalid webhook data.',
    'missing_required_fields' => 'Missing required fields.',
    'donation_not_found' => 'Donation not found.',
    'missing_invoice_key' => 'Missing invoice key.',
    
    // Payment verification
    'payment_verification_failed' => 'Failed to verify payment status.',
    
    // Fawaterak specific
    'fawry_code' => 'Fawry Code',
    'fawry_code_expires' => 'This code expires at',
    'meeza_reference' => 'Meeza Reference',
    'redirect_to_payment' => 'Please click the button below to proceed with the payment',
    'proceed_to_payment' => 'Proceed to Payment',
];
