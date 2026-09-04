<?php

namespace App\Traits;

use App\Models\Branch;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogsActivityWithBranch
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->getActivityLogName())
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getActivityLogName(): string
    {
        return Str::snake(class_basename(static::class), ' ');
    }

    public function tapActivity(Activity $activity, string $eventName): void
    {
        $activity->properties = $activity->properties->put(
            'branch',
            Branch::query()->find(session('branch_id'))?->name,
        );
    }
}
