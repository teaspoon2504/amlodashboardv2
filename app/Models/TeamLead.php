<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamLead extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'regional_office_id'];

    public function regionalOffice(): BelongsTo
    {
        return $this->belongsTo(RegionalOffice::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function officers(): HasMany
    {
        return $this->hasMany(Officer::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}