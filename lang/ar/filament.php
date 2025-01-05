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

    // User Resource
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
    ],
];
