<?php

return [
    // General
    'donation' => 'تبرع',
    'error_occurred' => 'حدث خطأ أثناء معالجة عملية الدفع.',
    'unknown_error' => 'حدث خطأ غير معروف.',
    
    // Payment info
    'campaign' => 'الحملة',
    'amount' => 'المبلغ',
    'currency' => 'العملة',
    'payment_method' => 'طريقة الدفع',
    'donate_anonymously' => 'التبرع بشكل مجهول',
    
    // Payment initialization
    'payment_initialized' => 'تمت تهيئة عملية الدفع بنجاح.',
    'payment_initialization_failed' => 'فشل في تهيئة عملية الدفع.',
    'payment_method_required' => 'طريقة الدفع مطلوبة.',
    'campaign_required' => 'الحملة مطلوبة.',
    'campaign_not_found' => 'الحملة غير موجودة.',
    'inactive_campaign' => 'هذه الحملة غير نشطة.',
    'amount_required' => 'المبلغ مطلوب.',
    'amount_numeric' => 'يجب أن يكون المبلغ رقمًا.',
    'amount_min' => 'يجب أن يكون المبلغ على الأقل 1.',
    'payment_method_invalid' => 'طريقة الدفع غير صالحة.',
    'invalid_share_amount' => 'بالنسبة لهذه الحملة، يجب أن يكون مبلغ التبرع :amount.',
    'amount_exceeds_remaining_goal' => 'مبلغ التبرع يتجاوز المبلغ المتبقي للهدف (:remaining).',
    
    // Payment status
    'payment_successful' => 'تمت معالجة عملية الدفع بنجاح.',
    'payment_failed' => 'فشلت عملية الدفع. يرجى المحاولة مرة أخرى.',
    'payment_pending' => 'عملية الدفع قيد الانتظار. سنقوم بإعلامك بمجرد معالجتها.',
    'offline_donation_created' => 'تم تسجيل تبرعك الغير متصل بالإنترنت.',
    
    // Webhook processing
    'webhook_processed' => 'تمت معالجة الويب هوك بنجاح.',
    'invalid_webhook_data' => 'بيانات الويب هوك غير صالحة.',
    'missing_required_fields' => 'حقول مطلوبة مفقودة.',
    'donation_not_found' => 'التبرع غير موجود.',
    'missing_invoice_key' => 'مفتاح الفاتورة مفقود.',
    
    // Payment verification
    'payment_verification_failed' => 'فشل في التحقق من حالة الدفع.',
    
    // Fawaterak specific
    'fawry_code' => 'كود فوري',
    'fawry_code_expires' => 'ينتهي هذا الكود في',
    'meeza_reference' => 'رقم مرجع ميزة',
    'redirect_to_payment' => 'يرجى النقر على الزر أدناه للمتابعة مع عملية الدفع',
    'proceed_to_payment' => 'متابعة الدفع',
];
