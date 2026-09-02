<?php

return [
    'currencies' => [
        'SAR' => 'Saudi Riyal',
        'EGP' => 'Egyptian Pound',
    ],

    'payment_methods' => [
        'cash' => 'Cash',
        'bank' => 'Bank Transfer',
        'visa' => 'Visa Card',
    ],

    'transaction_types' => [
        'in' => 'Income',
        'out' => 'Expense',
    ],

    'client_status' => [
        'active' => 'Active',
        'banned' => 'Banned',
    ],

    'room_type' => [
        'single' => 'Single',
        'double' => 'Double',
        'triple' => 'Triple',
        'quadrille' => 'Quadrille',
        'default' => 'Default',
    ],

    'trip_status' => [
        'draft' => 'Draft',
        'active' => 'Active',
    ],

    'trip_type' => [
        'flight' => 'Flight',
    ],

    'trip_activity' => [
        'omra' => 'Omra',
        'hajj' => 'Hajj',
    ],

    'role_enum' => [
        'super-admin' => 'Super Admin',
        'admin' => 'Admin',
        'employee' => 'Employee',
    ],

    'permission_actions' => [
        'viewAny' => 'View All',
        'view' => 'View',
        'create' => 'Create',
        'update' => 'Update',
        'delete' => 'Delete',
        'deleteAny' => 'Delete Any',
        'applyDiscount' => 'Apply Discount',
        'endSalary' => 'End Salary',
    ],

    'client_service_status' => [
        'pending' => 'Pending',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    'user_status' => [
        'active' => 'Active',
        'pending' => 'Pending',
        'banned' => 'Banned',
    ],

    'task_status' => [
        'draft' => 'Draft',
        'pending' => 'Pending',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    'task_completion_mode' => [
        'require_all' => 'All assignees must complete it',
        'require_any' => 'Any one assignee is enough',
    ],

    'task_assignment_status' => [
        'pending' => 'Pending',
        'completed' => 'Completed',
    ],
];
