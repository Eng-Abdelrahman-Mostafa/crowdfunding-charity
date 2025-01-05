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
    ],
];
