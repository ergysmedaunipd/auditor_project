<?php

namespace App\Models;
;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    protected $fillable = ['auditor_id', 'auditing_job_id',  'assessment_date', 'note'];

    /**
     * Get the auditor that owns the assessment.
     *
     * @return BelongsTo
     */
    public function auditor(): BelongsTo
    {
        return $this->belongsTo(Auditor::class);
    }

    /**
     * Get the auditing job that owns the assessment.
     *
     * @return BelongsTo
     */
    public function auditingJob(): BelongsTo
    {
        return $this->belongsTo(AuditingJob::class);
    }
}
