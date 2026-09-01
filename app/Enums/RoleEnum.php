<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Employee = 'employee';
}
