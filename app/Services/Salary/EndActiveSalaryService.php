<?php

namespace App\Services\Salary;

use App\Models\User;

class EndActiveSalaryService
{
    public function execute(User $user, string $endedAt): void
    {
        $user->salaries()
            ->whereNull('ended_at')
            ->update(['ended_at' => $endedAt]);
    }
}
