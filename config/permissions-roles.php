<?php

return [
    "permissions" => [
        "super-admin" => [
            [
                'name' => '*.*.*',
                'guard_name' => 'web',
            ]
        ],
        "users" => [
            [
                'name' => 'users.*.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'users.view.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'users.create.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'users.update.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'users.delete.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'users.change-status.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'users.restore.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'users.force-delete.*',
                'guard_name' => 'web',
            ],
        ],
        "associations" => [
            [
                'name' => 'associations.*.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'associations.view.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'associations.create.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'associations.update.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'associations.delete.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'associations.change-status.*',
                'guard_name' => 'web',
            ],
        ],
        "campaigns" => [
            [
                'name' => 'campaigns.*.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'campaigns.view.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'campaigns.create.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'campaigns.update.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'campaigns.delete.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'campaigns.change-status.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'campaigns.publish.*',
                'guard_name' => 'web',
            ],
        ],
        "donations" => [
            [
                'name' => 'donations.*.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'donations.view.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'donations.create.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'donations.change-status.*',
                'guard_name' => 'web',
            ],
        ],
        "withdrawals" => [
            [
                'name' => 'withdrawals.*.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'withdrawals.view.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'withdrawals.create.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'withdrawals.update.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'withdrawals.delete.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'withdrawals.approve.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'withdrawals.reject.*',
                'guard_name' => 'web',
            ],
        ],
        "donation-categories" => [
            [
                'name' => 'donation-categories.*.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'donation-categories.view.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'donation-categories.create.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'donation-categories.update.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'donation-categories.delete.*',
                'guard_name' => 'web',
            ],
        ],
        "expenditures" => [
            [
                'name' => 'expenditures.*.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'expenditures.view.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'expenditures.create.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'expenditures.update.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'expenditures.delete.*',
                'guard_name' => 'web',
            ],
        ],
        "dashboard" => [
            [
                'name' => 'dashboard.*.*',
                'guard_name' => 'web',
            ],
            [
                'name' => 'dashboard.view.*',
                'guard_name' => 'web',
            ],
        ],
    ],
    "roles" => [
        "super-admin" => [
            'guard_name' => 'web',
            'permissions' => [
                '*.*.*',
            ]
        ],
        "association-manager" => [
            'guard_name' => 'web',
            'permissions' => [
                'dashboard.view.*',
                'campaigns.*.*',
                'donations.view.*',
                'withdrawals.create.*',
                'withdrawals.view.*',
                'expenditures.*.*',
            ]
        ],
        "donor" => [
            'guard_name' => 'web',
            'permissions' => [
                'campaigns.view.*',
                'donations.create.*',
                'donations.view.*',
            ]
        ],
    ]
];
