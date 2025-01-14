<?php
return [
    'password' => 'كلمة المرور',
    'email' => 'البريد الالكتروني',
    // User Management
    'User Management' => 'إدارة المستخدمين',
    'Users' => 'المستخدمين',
    'Show Active Users' => 'عرض المستخدمين النشطين',
    'Show Deleted Users' => 'عرض المستخدمين المحذوفين',
    'Admin' => 'مدير النظام',
    'Association Manager' => 'مدير جمعية',
    'Donor' => 'متبرع',
    'Active' => 'نشط',
    'Inactive' => 'غير نشط',
    'Status' => 'الحالة',
    'Name' => 'الاسم',
    'Phone' => 'رقم الهاتف',
    'Type' => 'النوع',
    'Created At' => 'تاريخ الإنشاء',
    'All' => 'الكل',
    'User status updated successfully' => 'تم تحديث حالة المستخدم بنجاح',
    'User restored successfully' => 'تم استعادة المستخدم بنجاح',
    'User permanently deleted successfully' => 'تم حذف المستخدم نهائياً بنجاح',

    'resource' => [
        'user' => [
            'label' => 'مستخدم',
            'plural_label' => 'المستخدمين',
            'navigation_label' => 'المستخدمين',
            'navigation_group' => 'إدارة المستخدمين',
            'total_users' => 'إجمالي المستخدمين',

            // Form Fields
            'name' => 'الاسم',
            'phone' => 'رقم الهاتف',
            'type' => 'النوع',
            'status' => 'الحالة',
            'created_at' => 'تاريخ الإنشاء',
            'password' => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'email' => 'البريد الإلكتروني',

            // Actions
            'create' => 'إضافة مستخدم',
            'edit' => 'تعديل المستخدم',
            'view' => 'عرض المستخدم',
            'delete' => 'حذف المستخدم',
            'restore' => 'استعادة المستخدم',
            'force_delete' => 'حذف نهائي',
            'toggle_status' => 'تغيير الحالة',

            // Messages
            'created' => 'تم إنشاء المستخدم بنجاح',
            'updated' => 'تم تحديث المستخدم بنجاح',
            'deleted' => 'تم حذف المستخدم بنجاح',
            'restored' => 'تم استعادة المستخدم بنجاح',
            'permanently_deleted' => 'تم حذف المستخدم نهائياً',
            'status_updated' => 'تم تحديث حالة المستخدم بنجاح',
            'Are_you_sure_you_want_to_deactivate_this_user?' => 'هل أنت متأكد من أنك تريد إلغاء تنشيط هذا المستخدم؟',
            'Are_you_sure_you_want_to_permanently_delete_this_user?' => 'هل أنت متأكد من أنك تريد حذف هذا المستخدم نهائياً؟',
            'Are_you_sure_you_want_to_activate_this_user?' => 'هل أنت متأكد من أنك تريد تنشيط هذا المستخدم؟',
            'Are_you_sure_you_want_to_delete_this_user?' => 'هل أنت متأكد من أنك تريد حذف هذا المستخدم؟',
            'Are_you_sure_you_want_to_restore_this_user?' => 'هل أنت متأكد من أنك تريد استعادة هذا المستخدم؟',

            // Filters and Headers
            'show_deleted' => 'عرض المستخدمين المحذوفين',
            'show_active' => 'عرض المستخدمين النشطين',
            'filter_by_type' => 'تصفية حسب النوع',
            'filter_by_status' => 'تصفية حسب الحالة',
            'filter_by_date' => 'تصفية حسب التاريخ',
            'from_date' => 'من تاريخ',
            'to_date' => 'إلى تاريخ',

            // User Types
            'types' => [
                'admin' => 'مدير النظام',
                'association_manager' => 'مدير جمعية',
                'donor' => 'متبرع',
            ],

            // Status
            'statuses' => [
                'active' => 'نشط',
                'inactive' => 'غير نشط',
                'all' => 'الكل',
            ],

            'roles' => 'الأدوار',
            'associations' => 'الجمعيات',
            'select_roles' => 'اختر الأدوار',
            'select_associations' => 'اختر الجمعيات',
            'no_roles_selected' => 'لم يتم اختيار أي أدوار',
            'no_associations_selected' => 'لم يتم اختيار أي جمعيات',
        ],
        'association' => [
            'label' => 'جمعية',
            'plural_label' => 'الجمعيات',
            'navigation_label' => 'الجمعيات',
            'navigation_group' => 'إدارة الجمعيات',
            'total_associations' => 'إجمالي الجمعيات',

            // Form Fields
            'logo' => 'الشعار',
            'name' => 'الاسم',
            'description' => 'الوصف',
            'website' => 'الموقع الإلكتروني',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'address' => 'العنوان',
            'city' => 'المدينة',
            'state' => 'المنطقة/المحافظة',
            'zip' => 'الرمز البريدي',
            'country' => 'الدولة',
            'status' => 'الحالة',
            'created_at' => 'تاريخ الإنشاء',

            // Actions
            'create' => 'إنشاء جمعية',
            'edit' => 'تعديل الجمعية',
            'delete' => 'حذف الجمعية',
            'toggle_status' => 'تغيير الحالة',

            // Messages
            'created' => 'تم إنشاء الجمعية بنجاح',
            'updated' => 'تم تحديث الجمعية بنجاح',
            'deleted' => 'تم حذف الجمعية بنجاح',
            'status_updated' => 'تم تحديث حالة الجمعية بنجاح',

            // Filters and Headers
            'filter_by_status' => 'تصفية حسب الحالة',
            'filter_by_date' => 'تصفية حسب التاريخ',
            'from_date' => 'من تاريخ',
            'to_date' => 'إلى تاريخ',

            // Status Options
            'statuses' => [
                'active' => 'نشط',
                'inactive' => 'غير نشط',
            ],
        ],
        'donation_category' => [
            'label' => 'فئة التبرع',
            'plural_label' => 'فئات التبرع',
            'navigation_label' => 'الفئات',
            'navigation_group' => 'إدارة التبرعات',
            'total_categories' => 'إجمالي الفئات',

            // Form Fields
            'name' => 'الاسم',
            'created_at' => 'تاريخ الإنشاء',

            // Actions
            'create' => 'إنشاء فئة',
            'edit' => 'تعديل الفئة',
            'delete' => 'حذف الفئة',

            // Messages
            'created' => 'تم إنشاء الفئة بنجاح',
            'updated' => 'تم تحديث الفئة بنجاح',
            'deleted' => 'تم حذف الفئة بنجاح',
        ],
        'campaign' => [
            'label' => 'حملة',
            'plural_label' => 'الحملات',
            'navigation_label' => 'الحملات',
            'navigation_group' => 'إدارة الحملات',
            'total_campaigns' => 'إجمالي الحملات',
            'view_expenditures' => 'عرض المصروفات',
            // Form Fields
            'thumbnail' => 'الصورة',
            'name' => 'الاسم',
            'description' => 'الوصف',
            'address' => 'العنوان',
            'status' => 'الحالة',
            'goal_amount' => 'المبلغ المستهدف',
            'collected_amount' => 'المبلغ المجموع',
            'donation_type' => 'نوع التبرع',
            'share_amount' => 'قيمة السهم',
            'start_date' => 'تاريخ البداية',
            'end_date' => 'تاريخ النهاية',
            'association' => 'الجمعية',
            'category' => 'الفئة',

            // Actions
            'create' => 'إنشاء حملة',
            'edit' => 'تعديل الحملة',
            'delete' => 'حذف الحملة',
            'toggle_status' => 'تغيير الحالة',

            // Messages
            'created' => 'تم إنشاء الحملة بنجاح',
            'updated' => 'تم تحديث الحملة بنجاح',
            'deleted' => 'تم حذف الحملة بنجاح',
            'status_updated' => 'تم تحديث حالة الحملة بنجاح',

            // Filters and Headers
            'filter_by_status' => 'تصفية حسب الحالة',
            'filter_by_donation_type' => 'تصفية حسب نوع التبرع',
            'filter_by_association' => 'تصفية حسب الجمعية',
            'filter_by_category' => 'تصفية حسب الفئة',
            'filter_by_date' => 'تصفية حسب التاريخ',
            'from_date' => 'من تاريخ',
            'to_date' => 'إلى تاريخ',

            // Status Options
            'statuses' => [
                'active' => 'نشط',
                'inactive' => 'غير نشط',
            ],

            // Donation Types
            'donation_types' => [
                'open' => 'مبلغ مفتوح',
                'share' => 'سهم ثابت',
            ],

            'validation' => [
                'share_amount_less_than_goal' => 'يجب أن تكون قيمة السهم أقل من المبلغ المستهدف',
            ],

            'view_donations' => 'عرض التبرعات',
            'donations' => [
                'title' => 'التبرعات',
                'description' => 'إدارة تبرعات الحملة',
            ],
        ],
        'role' => [
            'label' => 'دور',
            'plural_label' => 'الأدوار',
            'navigation_label' => 'الأدوار',
            'navigation_group' => 'إدارة المستخدمين',

            // Fields
            'id' => 'المعرف',
            'name' => 'الاسم',
            'guard_name' => 'اسم الحارس',
            'permissions' => 'الصلاحيات',
            'permissions_count' => 'عدد الصلاحيات',
            'created_at' => 'تاريخ الإنشاء',

            // Actions
            'create' => 'إنشاء دور',
            'edit' => 'تعديل الدور',
            'delete' => 'حذف الدور',
            'delete_confirmation' => 'هل أنت متأكد من حذف هذا الدور؟',

            // Messages
            'created' => 'تم إنشاء الدور بنجاح',
            'updated' => 'تم تحديث الدور بنجاح',
            'deleted' => 'تم حذف الدور بنجاح',

            // Permission Groups
            'permissions_groups' => [
                'users' => [
                    'all' => 'جميع صلاحيات المستخدمين',
                    'view users' => 'عرض المستخدمين',
                    'create users' => 'إنشاء المستخدمين',
                    'update users' => 'تعديل المستخدمين',
                    'delete users' => 'حذف المستخدمين',
                    'change user status' => 'تغيير حالة المستخدمين',
                    'restore users' => 'استعادة المستخدمين',
                    'force delete users' => 'حذف المستخدمين نهائياً',
                ],
                'associations' => [
                    'all' => 'جميع صلاحيات الجمعيات',
                    'view associations' => 'عرض الجمعيات',
                    'create associations' => 'إنشاء الجمعيات',
                    'update associations' => 'تعديل الجمعيات',
                    'delete associations' => 'حذف الجمعيات',
                    'change association status' => 'تغيير حالة الجمعيات',
                ],
                'campaigns' => [
                    'all' => 'جميع صلاحيات الحملات',
                    'view campaigns' => 'عرض الحملات',
                    'create campaigns' => 'إنشاء الحملات',
                    'update campaigns' => 'تعديل الحملات',
                    'delete campaigns' => 'حذف الحملات',
                    'change campaign status' => 'تغيير حالة الحملات',
                    'restore campaigns' => 'استعادة الحملات',
                    'force delete campaigns' => 'حذف الحملات نهائياً',
                    'publish campaigns' => 'نشر الحملات',
                ],
                'donations' => [
                    'all' => 'جميع صلاحيات التبرعات',
                    'view donations' => 'عرض التبرعات',
                    'create donations' => 'إنشاء التبرعات',
                    'change donation status' => 'تغيير حالة التبرعات',
                ],
                'withdrawals' => [
                    'all' => 'جميع صلاحيات السحب',
                    'view withdrawals' => 'عرض عمليات السحب',
                    'create withdrawals' => 'إنشاء عمليات السحب',
                    'update withdrawals' => 'تعديل عمليات السحب',
                    'delete withdrawals' => 'حذف عمليات السحب',
                    'approve withdrawals' => 'الموافقة على عمليات السحب',
                    'reject withdrawals' => 'رفض عمليات السحب',
                ],
                'donation_categories' => [
                    'all' => 'جميع صلاحيات فئات التبرع',
                    'view donation categories' => 'عرض الفئات',
                    'create donation categories' => 'إنشاء الفئات',
                    'update donation categories' => 'تعديل الفئات',
                    'delete donation categories' => 'حذف الفئات',
                ],
                'expenditures' => [
                    'all' => 'جميع صلاحيات المصروفات',
                    'view expenditures' => 'عرض المصروفات',
                    'create expenditures' => 'إنشاء المصروفات',
                    'update expenditures' => 'تعديل المصروفات',
                    'delete expenditures' => 'حذف المصروفات',
                ],
                'dashboard' => [
                    'all' => 'جميع صلاحيات لوحة التحكم',
                    'view dashboard' => 'عرض لوحة التحكم',
                ],
            ],
        ],
        'donation' => [
            'label' => 'تبرع',
            'plural_label' => 'التبرعات',
            'navigation_label' => 'التبرعات',
            'navigation_group' => 'إدارة التبرعات',
            'total_donations' => 'إجمالي التبرعات',

            // Form Fields
            'donor' => 'المتبرع',
            'campaign' => 'الحملة',
            'amount' => 'المبلغ',
            'currency' => 'العملة',
            'status' => 'الحالة',
            'payment_method' => 'طريقة الدفع',
            'payment_with' => 'الدفع بواسطة',
            'paid_at' => 'تاريخ الدفع',
            'due_date' => 'تاريخ الاستحقاق',
            'created_at' => 'تاريخ الإنشاء',

            // Actions
            'create' => 'إنشاء تبرع',
            'edit' => 'تعديل التبرع',
            'delete' => 'حذف التبرع',
            'view' => 'عرض التبرع',
            'view_title' => 'عرض تبرع :name',

            // Messages
            'created' => 'تم إنشاء التبرع بنجاح',
            'deleted' => 'تم حذف التبرع بنجاح',

            // Filters and Headers
            'filter_by_status' => 'تصفية حسب الحالة',
            'filter_by_payment_method' => 'تصفية حسب طريقة الدفع',
            'filter_by_campaign' => 'تصفية حسب الحملة',
            'filter_by_date' => 'تصفية حسب التاريخ',
            'from_date' => 'من تاريخ',
            'to_date' => 'إلى تاريخ',

            // Status Options
            'statuses' => [
                'pending' => 'قيد الانتظار',
                'success' => 'ناجح',
                'failed' => 'فاشل',
            ],

            // Payment Methods
            'payment_methods' => [
                'online' => 'عبر الإنترنت',
                'offline' => 'غير متصل',
            ],
            'validation' => [
                'amount_exceeds_remaining_goal' => 'المبلغ يتجاوز المبلغ المتبقي',
            ],
            'attachments' => 'المرفقات',
        ],
        'expenditure' => [
            'label' => 'مصروف',
            'plural_label' => 'المصروفات',
            'navigation_label' => 'المصروفات',
            'navigation_group' => 'إدارة الحملات',
            'total_expenditures' => 'إجمالي المصروفات',

            // Form Fields
            'name' => 'الاسم',
            'amount' => 'المبلغ',
            'date' => 'التاريخ',
            'description' => 'الوصف',
            'receipt' => 'الإيصال',
            'campaign' => 'الحملة',
            'created_by' => 'تم الإنشاء بواسطة',

            // Actions
            'create' => 'إنشاء مصروف',
            'edit' => 'تعديل المصروف',
            'delete' => 'حذف المصروف',
            'view' => 'عرض المصروف',

            // Messages
            'created' => 'تم إنشاء المصروف بنجاح',
            'updated' => 'تم تحديث المصروف بنجاح',
            'deleted' => 'تم حذف المصروف بنجاح',

            // Filters and Headers
            'filter_by_campaign' => 'تصفية حسب الحملة',
            'filter_by_date' => 'تصفية حسب التاريخ',
            'from_date' => 'من تاريخ',
            'to_date' => 'إلى تاريخ',
            'all' => 'الكل',
        ],
    ],
];
