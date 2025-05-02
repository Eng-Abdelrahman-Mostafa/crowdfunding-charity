<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما :other يكون :value.',
    'active_url' => ':attribute يجب أن يكون عنوان URL صالحًا.',
    'after' => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخًا بعد أو مساوي لـ :date.',
    'alpha' => 'يجب أن يحتوي :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي :attribute على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون :attribute مصفوفة.',
    'ascii' => 'يجب أن يحتوي :attribute على أحرف ألفا-رقمية من البايت الواحد ورموز فقط.',
    'before' => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخًا قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن يكون لـ :attribute بين :min و :max عناصر.',
        'file' => 'يجب أن يكون :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'string' => 'يجب أن يكون :attribute بين :min و :max حروف.',
    ],
    'boolean' => 'يجب أن يكون حقل :attribute صحيحًا أو خاطئًا.',
    'can' => 'يحتوي حقل :attribute على قيمة غير مصرح بها.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => ':attribute يجب أن يكون تاريخًا صالحًا.',
    'date_equals' => 'يجب أن يكون :attribute تاريخًا يساوي :date.',
    'date_format' => 'يجب أن يتطابق :attribute مع الشكل :format.',
    'decimal' => 'يجب أن يكون :attribute :decimal من الأماكن العشرية.',
    'declined' => 'يجب أن يتم رفض :attribute.',
    'declined_if' => 'يجب أن يتم رفض :attribute عندما :other يكون :value.',
    'different' => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits' => 'يجب أن يكون :attribute :digits رقمًا.',
    'digits_between' => 'يجب أن يكون :attribute بين :min و :max رقمًا.',
    'dimensions' => ':attribute له أبعاد صورة غير صالحة.',
    'distinct' => 'حقل :attribute له قيمة مكررة.',
    'doesnt_end_with' => 'يجب ألا ينتهي :attribute بأحد الأشياء التالية: :values.',
    'doesnt_start_with' => 'يجب ألا يبدأ :attribute بأحد الأشياء التالية: :values.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
    'ends_with' => 'يجب أن ينتهي :attribute بأحد الأشياء التالية: :values.',
    'enum' => 'اختيار :attribute المحدد غير صالح.',
    'exists' => 'اختيار :attribute المحدد غير صالح.',
    'extensions' => 'يجب أن يكون لـ :attribute أحد الامتدادات التالية: :values.',
    'file' => 'يجب أن يكون :attribute ملفًا.',
    'filled' => 'يجب أن يكون لـ :attribute قيمة.',
    'gt' => [
        'array' => 'يجب أن يكون لـ :attribute أكثر من :value عناصر.',
        'file' => 'يجب أن يكون :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute أكبر من :value.',
        'string' => 'يجب أن يكون :attribute أكبر من :value حروف.',
    ],
    'gte' => [
        'array' => 'يجب أن يكون لـ :attribute :value عناصر أو أكثر.',
        'file' => 'يجب أن يكون :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute أكبر من أو يساوي :value.',
        'string' => 'يجب أن يكون :attribute أكبر من أو يساوي :value حروف.',
    ],
    'hex_color' => 'يجب أن يكون :attribute لونًا سداسيًا صالحًا.',
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => 'اختيار :attribute المحدد غير صالح.',
    'in_array' => 'يجب أن يكون :attribute موجودًا في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صالحًا.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صالحًا.',
    'json' => 'يجب أن يكون :attribute سلسلة JSON صالحة.',
    'lowercase' => 'يجب أن يكون :attribute بأحرف صغيرة.',
    'lt' => [
        'array' => 'يجب أن يكون لـ :attribute أقل من :value عناصر.',
        'file' => 'يجب أن يكون :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute أقل من :value.',
        'string' => 'يجب أن يكون :attribute أقل من :value حروف.',
    ],
    'lte' => [
        'array' => 'يجب ألا يكون لـ :attribute أكثر من :value عناصر.',
        'file' => 'يجب أن يكون :attribute أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute أقل من أو يساوي :value.',
        'string' => 'يجب أن يكون :attribute أقل من أو يساوي :value حروف.',
    ],
    'mac_address' => 'يجب أن يكون :attribute عنوان MAC صالح.',
    'max' => [
        'array' => 'يجب ألا يكون لـ :attribute أكثر من :max عناصر.',
        'file' => 'يجب ألا يكون :attribute أكبر من :max كيلوبايت.',
        'numeric' => 'يجب ألا يكون :attribute أكبر من :max.',
        'string' => 'يجب ألا يكون :attribute أكبر من :max حروف.',
    ],
    'max_digits' => 'يجب ألا يكون لـ :attribute أكثر من :max أرقام.',
    'mimes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
    'mimetypes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
    'min' => [
        'array' => 'يجب أن يكون لـ :attribute على الأقل :min عناصر.',
        'file' => 'يجب أن يكون :attribute على الأقل :min كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'string' => 'يجب أن يكون :attribute على الأقل :min حروف.',
    ],
    'min_digits' => 'يجب أن يكون لـ :attribute على الأقل :min أرقام.',
    'missing' => 'يجب أن يكون :attribute مفقودًا.',
    'missing_if' => 'يجب أن يكون :attribute مفقودًا عندما :other يكون :value.',
    'missing_unless' => 'يجب أن يكون :attribute مفقودًا إلا إذا كان :other هو :value.',
    'missing_with' => 'يجب أن يكون :attribute مفقودًا عندما :values موجود.',
    'missing_with_all' => 'يجب أن يكون :attribute مفقودًا عندما :values موجود.',
    'multiple_of' => 'يجب أن يكون :attribute مضاعفًا لـ :value.',
    'not_in' => 'اختيار :attribute المحدد غير صالح.',
    'not_regex' => 'تنسيق :attribute غير صالح.',
    'numeric' => 'يجب أن يكون :attribute رقمًا.',
    'password' => [
        'letters' => 'يجب أن يحتوي :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن يحتوي :attribute على حرف كبير واحد وحرف صغير واحد على الأقل.',
        'numbers' => 'يجب أن يحتوي :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن يحتوي :attribute على رمز واحد على الأقل.',
        'uncompromised' => 'ظهر :attribute المعطى في تسرب بيانات. يرجى اختيار :attribute مختلف.',
    ],
    'present' => 'يجب أن يكون الحقل :attribute موجودًا.',
    'present_if' => 'يجب أن يكون الحقل :attribute موجودًا عندما يكون :other هو :value.',
    'present_unless' => 'يجب أن يكون الحقل :attribute موجودًا إلا إذا كان :other هو :value.',
    'present_with' => 'يجب أن يكون الحقل :attribute موجودًا عندما يكون :values موجودًا.',
    'present_with_all' => 'يجب أن يكون الحقل :attribute موجودًا عندما يكون :values موجودًا.',
    'prohibited' => 'الحقل :attribute محظور.',
    'prohibited_if' => 'الحقل :attribute محظور عندما يكون :other هو :value.',
    'prohibited_unless' => 'الحقل :attribute محظور إلا إذا كان :other في :values.',
    'prohibits' => 'الحقل :attribute يحظر وجود :other.',
    'regex' => 'تنسيق الحقل :attribute غير صالح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي الحقل :attribute على إدخالات لـ: :values.',
    'required_if' => 'الحقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_if_accepted' => 'الحقل :attribute مطلوب عندما يتم قبول :other.',
    'required_unless' => 'الحقل :attribute مطلوب إلا إذا كان :other في :values.',
    'required_with' => 'الحقل :attribute مطلوب عندما يكون :values موجودًا.',
    'required_with_all' => 'الحقل :attribute مطلوب عندما يكون :values موجودًا.',
    'required_without' => 'الحقل :attribute مطلوب عندما لا يكون :values موجودًا.',
    'required_without_all' => 'الحقل :attribute مطلوب عندما لا يكون أي من :values موجودًا.',
    'same' => 'يجب أن يتطابق الحقل :attribute مع :other.',
    'size' => [
        'array' => 'يجب أن يحتوي الحقل :attribute على :size عناصر.',
        'file' => 'يجب أن يكون الحقل :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن يكون الحقل :attribute :size.',
        'string' => 'يجب أن يكون الحقل :attribute :size حروف.',
    ],
    'starts_with' => 'يجب أن يبدأ الحقل :attribute بأحد الأتباع: :values.',
    'string' => 'يجب أن يكون الحقل :attribute نصًا.',
    'timezone' => 'يجب أن يكون الحقل :attribute منطقة زمنية صالحة.',
    'unique' => 'تم أخذ الحقل :attribute بالفعل.',
    'uploaded' => 'فشل تحميل الحقل :attribute.',
    'uppercase' => 'يجب أن يكون الحقل :attribute بأحرف كبيرة.',
    'url' => 'يجب أن يكون الحقل :attribute عنوان URL صالح.',
    'ulid' => 'يجب أن يكون الحقل :attribute ULID صالح.',
    'uuid' => 'يجب أن يكون الحقل :attribute UUID صالح.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Rules
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation rules for attributes using the
    | convention "attribute.rule" to name the rules. This makes it quick
    | to specify a specific custom language line for a given attribute rule.
    |
    */
    'doesnt_exists_in_academy' => 'اختيار :attribute المحدد غير صالح.',
    'already_exists_in_academy' => 'اختيار :attribute المحدد موجود مسبقًا.',

    'phone' => 'يجب أن يكون :attribute رقم هاتف صالح.',

    'questions_not_enough' => 'عدد الأسئلة في ":part" غير كافية.',

    'single_choice_question_has_one_correct_option' => 'يجب أن يحتوي السؤال على خيار واحد صحيح.',
    'invalid_question_type' => 'نوع السؤال غير صالح.',

    'valid_external_media_url' => 'يجب أن يكون :attribute صالح.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'online_exam_id' => [
            'exam_prerequisite_conflict' => 'لا يمكن تحديد الاختبار عبر الإنترنت واختبار المتطلبات الأساسية معًا.',
            'exam_lesson_conflict' => 'لا يمكنك تحديد كل من الاختبار عبر الإنترنت والدرس عبر الإنترنت.',
        ],
        'online_lesson_id' => [
            'lesson_exam_conflict' => 'لا يمكنك تحديد كل من الدرس عبر الإنترنت والاختبار عبر الإنترنت.',
        ],
        'prerequisite_exam_id' => [
            'prerequisite_exam_conflict' => 'لا يمكن تحديد اختبار المتطلبات الأساسية والاختبار عبر الإنترنت معًا.',
        ],
        'online_content' => [
            'required' => 'يجب تقديم إما اختبار عبر الإنترنت أو درس عبر الإنترنت.',
        ],
        'allowed_views_number' => [
            'min' => 'يجب أن يكون عدد المشاهدات المسموح بها على الأقل 1.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'national_id' => 'الرقم القومي',

        'userId' => 'المستخدم',
        'banId' => 'الحظر',

        'countryId' => 'الدولة',
        'academiesId' => 'الأكاديميات',

        'academyId' => 'الأكاديمية',
        'academy' => 'الأكاديمية',
        'jobTitle' => 'المسمى الوظيفي',
        'role' => 'الدور',

        'educationalCategory' => 'الفئة التعليمية',

        'name' => 'الاسم',
        'phone' => 'الهاتف',
        'code' => 'الكود',
        'chance' => 'الفرصة',
        'mark' => 'الدرجة',
        'percentage' => 'النسبة',
        'start_at' => 'بداية الامتحان',
        'end_at' => 'نهاية الامتحان',
        'duration' => 'المدة',

        'identifier' => 'البريد الإلكتروني أو رقم الهاتف',
        'amount' => 'المبلغ',
    ],

];
