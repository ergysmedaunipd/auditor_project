<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auditor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'location' ];

    /**
     * Get the schedules for the auditor.
     *
     * @return HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the assessments for the auditor.
     *
     * @return HasMany
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
}
