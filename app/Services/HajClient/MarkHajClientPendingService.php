<?php

namespace App\Services\HajClient;

use App\Enums\HajClientStatus;
use App\Models\HajClient;

class MarkHajClientPendingService
{
    public function execute(HajClient $hajClient): void
    {
        $hajClient->update(['status' => HajClientStatus::Pending]);
    }
}
