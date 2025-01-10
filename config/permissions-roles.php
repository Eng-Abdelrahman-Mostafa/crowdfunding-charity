<?php

return [
    "permissions" => [
        "users" => [
            [
                'name' => 'view_users',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create_users',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update_users',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete_users',
                'guard_name' => 'web',
            ],
            [
                'name' => 'change_user_status',
                'guard_name' => 'web',
            ],
            [
                'name' => 'restore_users',
                'guard_name' => 'web',
            ],
            [
                'name' => 'force_delete_users',
                'guard_name' => 'web',
            ],
        ],
        "associations" => [
            [
                'name' => 'view_associations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create_associations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update_associations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete_associations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'change_association_status',
                'guard_name' => 'web',
            ],
        ],
        "campaigns" => [
            [
                'name' => 'view_campaigns',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create_campaigns',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update_campaigns',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete_campaigns',
                'guard_name' => 'web',
            ],
            [
                'name' => 'change_campaign_status',
                'guard_name' => 'web',
            ],
            [
                'name' => 'restore_campaigns',
                'guard_name' => 'web',
            ],
            [
                'name' => 'force_delete_campaigns',
                'guard_name' => 'web',
            ],
            [
                'name' => 'publish_campaigns',
                'guard_name' => 'web',
            ],
        ],
        "donations" => [
            [
                'name' => 'view_donations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create_donations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'change_donation_status',
                'guard_name' => 'web',
            ],
        ],
        "withdrawals" => [
            [
                'name' => 'view_withdrawals',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create_withdrawals',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update_withdrawals',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete_withdrawals',
                'guard_name' => 'web',
            ],
            [
                'name' => 'approve_withdrawals',
                'guard_name' => 'web',
            ],
            [
                'name' => 'reject_withdrawals',
                'guard_name' => 'web',
            ],
        ],
        "donation_categories" => [
            [
                'name' => 'view_donation_categories',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create_donation_categories',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update_donation_categories',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete_donation_categories',
                'guard_name' => 'web',
            ],
        ],
        "expenditures" => [
            [
                'name' => 'view_expenditures',
                'guard_name' => 'web',
            ],
            [
                'name' => 'create_expenditures',
                'guard_name' => 'web',
            ],
            [
                'name' => 'update_expenditures',
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete_expenditures',
                'guard_name' => 'web',
            ],
        ],
        "dashboard" => [
            [
                'name' => 'view_dashboard',
                'guard_name' => 'web',
            ],
        ],
    ],
    "roles" => [
        "super-admin" => [
            'guard_name' => 'web',
            'permissions' => [
                'view_users',
                'create_users',
                'update_users',
                'delete_users',
                'change_user_status',
                'restore_users',
                'force_delete_users',
                'view_associations',
                'create_associations',
                'update_associations',
                'delete_associations',
                'change_association_status',
                'view_campaigns',
                'create_campaigns',
                'update_campaigns',
                'delete_campaigns',
                'change_campaign_status',
                'restore_campaigns',
                'force_delete_campaigns',
                'publish_campaigns',
                'view_donations',
                'create_donations',
                'change_donation_status',
                'view_withdrawals',
                'create_withdrawals',
                'update_withdrawals',
                'delete_withdrawals',
                'approve_withdrawals',
                'reject_withdrawals',
                'view_donation_categories',
                'create_donation_categories',
                'update_donation_categories',
                'delete_donation_categories',
                'view_expenditures',
                'create_expenditures',
                'update_expenditures',
                'delete_expenditures',
                'view_dashboard',
            ]
        ],
        "association-manager" => [
            'guard_name' => 'web',
            'permissions' => [
                'view_dashboard',
                'view_campaigns',
                'create_campaigns',
                'update_campaigns',
                'delete_campaigns',
                'change_campaign_status',
                'publish_campaigns',
                'view_donations',
                'view_withdrawals',
                'create_withdrawals',
                'view_expenditures',
                'create_expenditures',
                'update_expenditures',
                'delete_expenditures',
            ]
        ],
        "donor" => [
            'guard_name' => 'web',
            'permissions' => [
                'view_campaigns',
                'create_donations',
                'view_donations',
            ]
        ],
    ]
];
