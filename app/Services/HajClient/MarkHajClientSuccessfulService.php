<?php

namespace App\Services\HajClient;

use App\Enums\HajClientStatus;
use App\Models\HajClient;

class MarkHajClientSuccessfulService
{
    public function execute(HajClient $hajClient): void
    {
        $hajClient->update(['status' => HajClientStatus::Successful]);
    }
}
