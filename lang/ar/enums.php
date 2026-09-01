<?php

return [
    'currencies' => [
        'SAR' => 'الريال السعودي',
        'EGP' => 'الجنيه المصري',
    ],

    'payment_methods' => [
        'cash' => 'نقداً',
        'bank' => 'تحويل بنكي',
        'visa' => 'فيزا',
    ],

    'transaction_types' => [
        'in' => 'دخل',
        'out' => 'مصروف',
    ],

    'client_status' => [
        'active' => 'نشط',
        'banned' => 'محظور',
    ],

    'room_type' => [
        'single' => 'فردي',
        'double' => 'مزدوج',
        'triple' => 'ثلاثي',
        'quadrille' => 'رباعي',
        'default' => 'افتراضي',
    ],

    'trip_status' => [
        'draft' => 'مسودة',
        'active' => 'نشط',
    ],

    'trip_type' => [
        'flight' => 'طيران',
    ],

    'trip_activity' => [
        'omra' => 'عمرة',
        'hajj' => 'حج',
    ],

    'role_enum' => [
        'super-admin' => 'مدير عام',
        'admin' => 'مدير',
        'employee' => 'موظف',
    ],

    'permission_actions' => [
        'viewAny' => 'عرض الكل',
        'view' => 'عرض',
        'create' => 'إنشاء',
        'update' => 'تعديل',
        'delete' => 'حذف',
        'deleteAny' => 'حذف جماعي',
        'applyDiscount' => 'تطبيق خصم',
        'endSalary' => 'إنهاء الراتب',
    ],

    'client_service_status' => [
        'pending' => 'قيد الانتظار',
        'completed' => 'مكتملة',
        'cancelled' => 'ملغاة',
    ],

    'user_status' => [
        'active' => 'نشط',
        'pending' => 'قيد الانتظار',
        'banned' => 'محظور',
    ],
];
