<?php

namespace App\Services\HajClient;

use App\Enums\HajClientStatus;
use App\Models\HajClient;

class MarkHajClientReserveService
{
    public function execute(HajClient $hajClient): void
    {
        $hajClient->update(['status' => HajClientStatus::Reserve]);
    }
}
