<?php

namespace App\Models;

use App\Enums\AuditingJobs\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static isAvailable()
 */
class AuditingJob extends Model
{
    protected $fillable = ['description', 'status'];

    /**
     * Scope a query to only include available auditing jobs.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsAvailable(Builder $query): Builder
    {
        return $query->where('status', Status::SCHEDULED);
    }
    /**
     * Scope a query to only include auditing jobs that are in progress.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsInProgress(Builder $query): Builder
    {
        return $query->where('status', Status::IN_PROGRESS);
    }
    /**
     * Scope a query to only include completed auditing jobs.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsCompleted(Builder $query): Builder
    {
        return $query->where('status', Status::COMPLETED);
    }
    /**
     * Get the schedules for the auditing job.
     *
     * @return HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the assessments for the auditing job.
     *
     * @return HasMany
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
}
