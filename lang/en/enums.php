<?php

return [
    'currencies' => [
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

    'package_status' => [
        'draft' => 'Draft',
        'active' => 'Active',
    ],

    'package_type' => [
        'flight' => 'Flight',
    ],

    'booking_status' => [
        'draft' => 'Draft',
        'pending' => 'Pending',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'refunded' => 'Refunded',
    ],

    'haj_client_status' => [
        'no_show' => 'No Show',
        'successful' => 'Successful',
        'unsuccessful' => 'Unsuccessful',
        'reserve' => 'Reserve',
        'withdrawn' => 'Withdrawn',
    ],

    'haj_client_dependency_type' => [
        'independent' => 'Independent',
        'dependent' => 'Dependent',
    ],

    'haj_client_relation_type' => [
        'husband' => 'Husband',
        'wife' => 'Wife',
        'father' => 'Father',
        'mother' => 'Mother',
        'son' => 'Son',
        'daughter' => 'Daughter',
        'brother' => 'Brother',
        'sister' => 'Sister',
        'grandfather' => 'Grandfather',
        'grandmother' => 'Grandmother',
        'paternal_uncle' => 'Paternal Uncle',
        'paternal_aunt' => 'Paternal Aunt',
        'maternal_uncle' => 'Maternal Uncle',
        'maternal_aunt' => 'Maternal Aunt',
        'relative' => 'Relative',
        'friend' => 'Friend',
        'other' => 'Other',
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
        'cancel' => 'Cancel',
        'refund' => 'Refund',
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
