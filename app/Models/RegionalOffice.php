<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegionalOffice extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function teamLead(): BelongsTo
    {
        return $this->belongsTo(TeamLead::class);
    }

    public function branchOffices(): HasMany
    {
        return $this->hasMany(BranchOffice::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}