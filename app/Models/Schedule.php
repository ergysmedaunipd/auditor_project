<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = ['auditor_id', 'auditing_job_id', 'scheduled_date','completed_date'];

    /**
     * Get the auditor that owns the schedule.
     *
     * @return BelongsTo
     */
    public function auditor(): BelongsTo
    {
        return $this->belongsTo(Auditor::class);
    }

    /**
     * Get the auditing job that owns the schedule.
     *
     * @return BelongsTo
     */
    public function auditingJob(): BelongsTo
    {
        return $this->belongsTo(AuditingJob::class);
    }
}
