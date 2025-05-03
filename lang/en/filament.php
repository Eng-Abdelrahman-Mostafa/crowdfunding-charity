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
            'view_expenditures' => 'View Expenditures',
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

            'view_donations' => 'View Donations',
            'donations' => [
                'title' => 'Donations',
                'description' => 'Manage campaign donations',
            ],
            'request_withdrawal' => 'Request Withdrawal',
            'request-withdrawal' => 'Request-Withdrawal',
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
        'donation' => [
            'label' => 'Donation',
            'plural_label' => 'Donations',
            'navigation_label' => 'Donations',
            'navigation_group' => 'Donation Management',
            'total_donations' => 'Total Donations',

            // Form Fields
            'donor' => 'Donor',
            'campaign' => 'Campaign',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'status' => 'Status',
            'payment_method' => 'Payment Method',
            'payment_with' => 'Payment With',
            'paid_at' => 'Paid At',
            'due_date' => 'Due Date',
            'created_at' => 'Created At',

            // Actions
            'create' => 'Create Donation',
            'edit' => 'Edit Donation',
            'delete' => 'Delete Donation',
            'view' => 'View Donation',
            'view_title' => 'Viewing Donation by :name',

            // Messages
            'created' => 'Donation created successfully',
            'deleted' => 'Donation deleted successfully',

            // Filters and Headers
            'filter_by_status' => 'Filter by Status',
            'filter_by_payment_method' => 'Filter by Payment Method',
            'filter_by_campaign' => 'Filter by Campaign',
            'filter_by_date' => 'Filter by Date',
            'from_date' => 'From Date',
            'to_date' => 'To Date',

            // Status Options
            'statuses' => [
                'pending' => 'Pending',
                'success' => 'Success',
                'failed' => 'Failed',
            ],

            // Payment Methods
            'payment_methods' => [
                'online' => 'Online',
                'offline' => 'Offline',
                'Credit Card' => 'Credit Card',
                'Bank Transfer' => 'Bank Transfer',
                'Cash' => 'Cash',
                'Fawry' => 'Fawry',
                'Meeza' => 'Meeza',
                'PayPal' => 'PayPal',
            ],
            'validation' => [
                'amount_exceeds_remaining_goal' => 'The donation amount exceeds the remaining goal amount (:remaining)',
            ],

            'attachments' => 'Attachments',
        ],
        'expenditure' => [
            'label' => 'Expenditure',
            'plural_label' => 'Expenditures',
            'navigation_label' => 'Expenditures',
            'navigation_group' => 'Campaign Management',
            'total_expenditures' => 'Total Expenditures',

            // Form Fields
            'name' => 'Name',
            'amount' => 'Amount',
            'date' => 'Date',
            'description' => 'Description',
            'receipt' => 'Receipt',
            'campaign' => 'Campaign',
            'created_by' => 'Created By',

            // Actions
            'create' => 'Create Expenditure',
            'edit' => 'Edit Expenditure',
            'delete' => 'Delete Expenditure',
            'view' => 'View Expenditure',

            // Messages
            'created' => 'Expenditure created successfully',
            'updated' => 'Expenditure updated successfully',
            'deleted' => 'Expenditure deleted successfully',

            // Filters and Headers
            'filter_by_campaign' => 'Filter by Campaign',
            'filter_by_date' => 'Filter by Date',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'all' => 'All',
        ],
        'withdrawal' => [
            'notifications' => [
                'new_request' => 'New Withdrawal Request',
                'new_request_body' => 'New withdrawal request of :amount from :association' . "\n" . 'for campaign: :campaign',
                'view_request' => 'View Request',
                'request_approved' => 'Withdrawal Request Approved',
                'request_rejected' => 'Withdrawal Request Rejected',
                'status_updated' => 'Withdrawal Request Status Updated',
                'status_updated_body' => 'Your withdrawal request of :amount from :association' . "\n" . 'for campaign: :campaign' . "\n" . 'has been updated to: :status',
                'rejection_note' => 'Rejection Note: :note',
            ],

            'label' => 'Withdrawal',
            'plural_label' => 'Withdrawals',
            'navigation_label' => 'Withdrawals',
            'navigation_group' => 'Financial Management',
            'total_withdrawals' => 'Total Withdrawals',

            // Form Fields
            'association' => 'Association',
            'campaign' => 'Campaign',
            'amount' => 'Amount',
            'status' => 'Status',
            'note' => 'Note',
            'requested_at' => 'Requested At',
            'processed_at' => 'Processed At',
            'requester' => 'Requester',
            'processor' => 'Processor',
            'available_balance' => 'Available Balance: :amount',
            'amount_helper' => 'Enter the amount you want to withdraw',
            'rejection_note' => 'Rejection Note',

            // Actions
            'create' => 'Create Withdrawal',
            'edit' => 'Edit Withdrawal',
            'view' => 'View Withdrawal',
            'delete' => 'Delete Withdrawal',
            'approve' => 'Approve Withdrawal',
            'reject' => 'Reject Withdrawal',
            'request_withdrawal' => 'Request Withdrawal',

            // Messages
            'created' => 'Withdrawal request created successfully',
            'updated' => 'Withdrawal updated successfully',
            'deleted' => 'Withdrawal deleted successfully',
            'approved' => 'Withdrawal approved successfully',
            'rejected' => 'Withdrawal rejected successfully',
            'requested' => 'Withdrawal requested successfully',

            // Confirmations
            'approve_confirmation' => 'Are you sure you want to approve this withdrawal?',
            'reject_confirmation' => 'Are you sure you want to reject this withdrawal?',

            // Status Options
            'statuses' => [
                'pending' => 'Pending',
                'success' => 'Success',
                'failed' => 'Failed',
            ],

            // Filters and Headers
            'filter_by_status' => 'Filter by Status',
            'filter_by_association' => 'Filter by Association',
            'filter_by_date' => 'Filter by Date',
            'from_date' => 'From Date',
            'to_date' => 'To Date',

            // Validation
            'validation' => [
                'amount_exceeds_balance' => 'The requested amount (:amount) exceeds the available balance (:available)',
                'invalid_amount' => 'The amount is invalid',
                'campaign_inactive' => 'The campaign is inactive',
                'pending_request_exists' => 'A pending withdrawal request already exists for this campaign',
            ],

            'actions' => [
                'process_request' => 'Process Request',
                'view_campaign' => 'View Campaign',
                'download_receipt' => 'Download Receipt',
            ],

            'status_messages' => [
                'pending_approval' => 'Pending Approval',
                'processing' => 'Processing',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ],
        ],
    ],
];
