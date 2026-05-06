<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'regional_office_id',
        'task_category_id',
        'team_lead_id',
        'officer_id',
        'branch_office_id',
        'description',
        'feedback',
        'progress',
        'target',
        'amount_done',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'target' => 'integer',
            'amount_done' => 'integer',
        ];
    }

    public const PROGRESS_DONE = 'done';
    public const PROGRESS_IN_PROGRESS = 'in_progress';
    public const PROGRESS_NOT_STARTED = 'not_started';

    public const PROGRESSES = [
        self::PROGRESS_DONE,
        self::PROGRESS_IN_PROGRESS,
        self::PROGRESS_NOT_STARTED,
    ];

    // ---- Relationships ----
    public function regionalOffice(): BelongsTo
    {
        return $this->belongsTo(RegionalOffice::class);
    }

    public function taskCategory(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class, 'task_category_id');
    }

    public function teamLead(): BelongsTo
    {
        return $this->belongsTo(TeamLead::class);
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(Officer::class);
    }

    public function branchOffice(): BelongsTo
    {
        return $this->belongsTo(BranchOffice::class);
    }

    // ---- Accessors ----
    protected function progressPercent(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->target > 0
                ? (int) min(100, round(($this->amount_done / $this->target) * 100))
                : 0,
        );
    }

    protected function isOverdue(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->due_date
                && $this->due_date->isPast()
                && $this->progress !== self::PROGRESS_DONE,
        );
    }

    // ---- Business Logic ----
    public function syncProgressFromAmount(): void
    {
        $newProgress = match (true) {
            $this->amount_done >= $this->target => self::PROGRESS_DONE,
            $this->amount_done > 0 => self::PROGRESS_IN_PROGRESS,
            default => self::PROGRESS_NOT_STARTED,
        };

        if ($this->getAttributeValue('progress') !== $newProgress) {
            $this->progress = $newProgress;
        }
    }
}