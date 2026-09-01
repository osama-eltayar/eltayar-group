<?php

namespace App\Policies;

use App\Models\Salary;
use App\Models\User;

class SalaryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnySalary');
    }

    public function view(User $user, Salary $salary): bool
    {
        return $user->can('viewSalary');
    }

    public function create(User $user): bool
    {
        return $user->can('createSalary');
    }

    public function update(User $user, Salary $salary): bool
    {
        return $user->can('updateSalary') && $salary->logs()->doesntExist();
    }

    public function delete(User $user, Salary $salary): bool
    {
        return $user->can('deleteSalary');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnySalary');
    }

    public function endSalary(User $user, Salary $salary): bool
    {
        return $user->can('endSalarySalary');
    }
}
