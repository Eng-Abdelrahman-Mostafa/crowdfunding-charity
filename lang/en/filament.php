<?php
return [
    'password' => 'Password',
    'email' => 'Email',
    // User Management
    'User Management' => 'User Management',
    'Users' => 'Users',
    'Show Active Users' => 'Show Active Users',
    'Show Deleted Users' => 'Show Deleted Users',
    'Admin' => 'Admin',
    'Association Manager' => 'Association Manager',
    'Donor' => 'Donor',
    'Active' => 'Active',
    'Inactive' => 'Inactive',
    'Status' => 'Status',
    'Name' => 'Name',
    'Phone' => 'Phone',
    'Type' => 'Type',
    'Created At' => 'Created At',
    'All' => 'All',
    'User status updated successfully' => 'User status updated successfully',
    'User restored successfully' => 'User restored successfully',
    'User permanently deleted successfully' => 'User permanently deleted successfully',

    // User Resource
    'resource' => [
        'user' => [
            'label' => 'User',
            'plural_label' => 'Users',
            'navigation_label' => 'Users',
            'navigation_group' => 'User Management',
            'total_users' => 'Total Users',

            // Form Fields
            'name' => 'Name',
            'phone' => 'Phone Number',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
            'email' => 'Email',

            // Actions
            'create' => 'Create User',
            'edit' => 'Edit User',
            'view' => 'View User',
            'delete' => 'Delete User',
            'restore' => 'Restore User',
            'force_delete' => 'Permanently Delete',
            'toggle_status' => 'Toggle Status',

            // Messages
            'created' => 'User created successfully',
            'updated' => 'User updated successfully',
            'deleted' => 'User deleted successfully',
            'restored' => 'User restored successfully',
            'permanently_deleted' => 'User permanently deleted',
            'status_updated' => 'User status updated successfully',
            'Are_you_sure_you_want_to_deactivate_this_user?' => 'Are you sure you want to deactivate this user?',
            'Are_you_sure_you_want_to_permanently_delete_this_user?' => 'Are you sure you want to permanently delete this user?',
            'Are_you_sure_you_want_to_activate_this_user?' => 'Are you sure you want to activate this user?',
            'Are_you_sure_you_want_to_delete_this_user?' => 'Are you sure you want to delete this user?',
            'Are_you_sure_you_want_to_restore_this_user?' => 'Are you sure you want to restore this user?',

            // Filters and Headers
            'show_deleted' => 'Show Deleted Users',
            'show_active' => 'Show Active Users',
            'filter_by_type' => 'Filter by Type',
            'filter_by_status' => 'Filter by Status',
            'filter_by_date' => 'Filter by Date',
            'from_date' => 'From Date',
            'to_date' => 'To Date',

            // User Types
            'types' => [
                'admin' => 'Admin',
                'association_manager' => 'Association Manager',
                'donor' => 'Donor',
            ],

            // Status
            'statuses' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
                'all' => 'All',
            ],

            'roles' => 'Roles',
            'associations' => 'Associations',
            'select_roles' => 'Select Roles',
            'select_associations' => 'Select Associations',
            'no_roles_selected' => 'No roles selected',
            'no_associations_selected' => 'No associations selected',
        ],
        'association' => [
            'label' => 'Association',
            'plural_label' => 'Associations',
            'navigation_label' => 'Associations',
            'navigation_group' => 'Association Management',
            'total_associations' => 'Total Associations',

            // Form Fields
            'logo' => 'Logo',
            'name' => 'Name',
            'description' => 'Description',
            'website' => 'Website',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State/Province',
            'zip' => 'Postal Code',
            'country' => 'Country',
            'status' => 'Status',
            'created_at' => 'Created At',

            // Actions
            'create' => 'Create Association',
            'edit' => 'Edit Association',
            'delete' => 'Delete Association',
            'toggle_status' => 'Toggle Status',

            // Messages
            'created' => 'Association created successfully',
            'updated' => 'Association updated successfully',
            'deleted' => 'Association deleted successfully',
            'status_updated' => 'Association status updated successfully',

            // Filters and Headers
            'filter_by_status' => 'Filter by Status',
            'filter_by_date' => 'Filter by Date',
            'from_date' => 'From Date',
            'to_date' => 'To Date',

            // Status Options
            'statuses' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ],
        'donation_category' => [
            'label' => 'Donation Category',
            'plural_label' => 'Donation Categories',
            'navigation_label' => 'Categories',
            'navigation_group' => 'Donation Management',
            'total_categories' => 'Total Categories',

            // Form Fields
            'name' => 'Name',
            'created_at' => 'Created At',

            // Actions
            'create' => 'Create Category',
            'edit' => 'Edit Category',
            'delete' => 'Delete Category',

            // Messages
            'created' => 'Category created successfully',
            'updated' => 'Category updated successfully',
            'deleted' => 'Category deleted successfully',
        ],
        'campaign' => [
            'label' => 'Campaign',
            'plural_label' => 'Campaigns',
            'navigation_label' => 'Campaigns',
            'navigation_group' => 'Campaign Management',
            'total_campaigns' => 'Total Campaigns',

            // Form Fields
            'thumbnail' => 'Thumbnail',
            'name' => 'Name',
            'description' => 'Description',
            'address' => 'Address',
            'status' => 'Status',
            'goal_amount' => 'Goal Amount',
            'collected_amount' => 'Collected Amount',
            'donation_type' => 'Donation Type',
            'share_amount' => 'Share Amount',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'association' => 'Association',
            'category' => 'Category',

            // Actions
            'create' => 'Create Campaign',
            'edit' => 'Edit Campaign',
            'delete' => 'Delete Campaign',
            'toggle_status' => 'Toggle Status',

            // Messages
            'created' => 'Campaign created successfully',
            'updated' => 'Campaign updated successfully',
            'deleted' => 'Campaign deleted successfully',
            'status_updated' => 'Campaign status updated successfully',

            // Filters and Headers
            'filter_by_status' => 'Filter by Status',
            'filter_by_donation_type' => 'Filter by Donation Type',
            'filter_by_association' => 'Filter by Association',
            'filter_by_category' => 'Filter by Category',
            'filter_by_date' => 'Filter by Date',
            'from_date' => 'From Date',
            'to_date' => 'To Date',

            // Status Options
            'statuses' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],

            // Donation Types
            'donation_types' => [
                'open' => 'Open Amount',
                'share' => 'Fixed Share',
            ],
            'validation' => [
                'share_amount_less_than_goal' => 'Share amount must be less than goal amount',
            ],
        ],
        'role' => [
            'label' => 'Role',
            'plural_label' => 'Roles',
            'navigation_label' => 'Roles',
            'navigation_group' => 'User Management',

            // Fields
            'id' => 'ID',
            'name' => 'Name',
            'guard_name' => 'Guard Name',
            'permissions' => 'Permissions',
            'permissions_count' => 'Permissions Count',
            'created_at' => 'Created At',

            // Actions
            'create' => 'Create Role',
            'edit' => 'Edit Role',
            'delete' => 'Delete Role',
            'delete_confirmation' => 'Are you sure you want to delete this role?',

            // Messages
            'created' => 'Role created successfully',
            'updated' => 'Role updated successfully',
            'deleted' => 'Role deleted successfully',

            // Permission Groups
            'permissions_groups' => [
                'users' => [
                    'all' => 'All User Permissions',
                    'view users' => 'View Users',
                    'create users' => 'Create Users',
                    'update users' => 'Update Users',
                    'delete users' => 'Delete Users',
                    'change user status' => 'Change User Status',
                    'restore users' => 'Restore Users',
                    'force delete users' => 'Force Delete Users',
                ],
                'associations' => [
                    'all' => 'All Association Permissions',
                    'view associations' => 'View Associations',
                    'create associations' => 'Create Associations',
                    'update associations' => 'Update Associations',
                    'delete associations' => 'Delete Associations',
                    'change association status' => 'Change Association Status',
                ],
                'campaigns' => [
                    'all' => 'All Campaign Permissions',
                    'view campaigns' => 'View Campaigns',
                    'create campaigns' => 'Create Campaigns',
                    'update campaigns' => 'Update Campaigns',
                    'delete campaigns' => 'Delete Campaigns',
                    'change campaign status' => 'Change Campaign Status',
                    'restore campaigns' => 'Restore Campaigns',
                    'force delete campaigns' => 'Force Delete Campaigns',
                    'publish campaigns' => 'Publish Campaigns',
                ],
                'donations' => [
                    'all' => 'All Donation Permissions',
                    'view donations' => 'View Donations',
                    'create donations' => 'Create Donations',
                    'change donation status' => 'Change Donation Status',
                ],
                'withdrawals' => [
                    'all' => 'All Withdrawal Permissions',
                    'view withdrawals' => 'View Withdrawals',
                    'create withdrawals' => 'Create Withdrawals',
                    'update withdrawals' => 'Update Withdrawals',
                    'delete withdrawals' => 'Delete Withdrawals',
                    'approve withdrawals' => 'Approve Withdrawals',
                    'reject withdrawals' => 'Reject Withdrawals',
                ],
                'donation_categories' => [
                    'all' => 'All Donation Category Permissions',
                    'view donation categories' => 'View Categories',
                    'create donation categories' => 'Create Categories',
                    'update donation categories' => 'Update Categories',
                    'delete donation categories' => 'Delete Categories',
                ],
                'expenditures' => [
                    'all' => 'All Expenditure Permissions',
                    'view expenditures' => 'View Expenditures',
                    'create expenditures' => 'Create Expenditures',
                    'update expenditures' => 'Update Expenditures',
                    'delete expenditures' => 'Delete Expenditures',
                ],
                'dashboard' => [
                    'all' => 'All Dashboard Permissions',
                    'view dashboard' => 'View Dashboard',
                ],
            ],
        ],
    ],
];
