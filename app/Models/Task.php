<?php

namespace App\Models;

use App\Enums\TaskCompletionMode;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'created_by',
        'status',
        'completion_mode',
        'finished_at',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'completion_mode' => TaskCompletionMode::class,
        'finished_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TaskAssignment::class);
    }

    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_assignments')
            ->withPivot(['status', 'comment', 'completed_at'])
            ->withTimestamps();
    }

    public function hasMultipleAssignees(): bool
    {
        return $this->assignments()->count() > 1;
    }
}
