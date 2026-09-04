<?php

namespace App\Models;

use App\Enums\TaskAssignmentStatus;
use App\Traits\LogsActivityWithBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskAssignment extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    protected $fillable = [
        'task_id',
        'user_id',
        'status',
        'comment',
        'completed_at',
    ];

    protected $casts = [
        'status' => TaskAssignmentStatus::class,
        'completed_at' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
