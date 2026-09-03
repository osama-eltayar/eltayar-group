<?php

return [
    'currencies' => [
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

    'package_status' => [
        'draft' => 'مسودة',
        'active' => 'نشط',
    ],

    'package_type' => [
        'flight' => 'طيران',
    ],

    'booking_status' => [
        'draft' => 'مسودة',
        'pending' => 'قيد الانتظار',
        'completed' => 'مكتملة',
        'cancelled' => 'ملغاة',
        'refunded' => 'مسترجعة',
    ],

    'haj_client_status' => [
        'no_show' => 'لم تظهر',
        'successful' => 'ناجح',
        'unsuccessful' => 'غير ناجح',
        'reserve' => 'احتياطي',
        'withdrawn' => 'منسحب',
    ],

    'haj_client_dependency_type' => [
        'independent' => 'مستقل',
        'dependent' => 'تابع',
    ],

    'haj_client_relation_type' => [
        'husband' => 'زوج',
        'wife' => 'زوجة',
        'father' => 'أب',
        'mother' => 'أم',
        'son' => 'ابن',
        'daughter' => 'ابنة',
        'brother' => 'أخ',
        'sister' => 'أخت',
        'grandfather' => 'جد',
        'grandmother' => 'جدة',
        'paternal_uncle' => 'عم',
        'paternal_aunt' => 'عمة',
        'maternal_uncle' => 'خال',
        'maternal_aunt' => 'خالة',
        'relative' => 'قريب',
        'friend' => 'صديق',
        'other' => 'أخرى',
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
        'cancel' => 'إلغاء',
        'refund' => 'استرجاع',
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

    'task_status' => [
        'draft' => 'مسودة',
        'pending' => 'قيد الانتظار',
        'completed' => 'مكتملة',
        'cancelled' => 'ملغاة',
    ],

    'task_completion_mode' => [
        'require_all' => 'يجب أن يُنجزها جميع المكلفين',
        'require_any' => 'يكفي أن يُنجزها أحد المكلفين',
    ],

    'task_assignment_status' => [
        'pending' => 'قيد الانتظار',
        'completed' => 'منجزة',
    ],
];
