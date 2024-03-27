<?php

namespace App\Services;

use App\Enums\AuditingJobs\Status;
use App\Models\Assessment;
use App\Models\AuditingJob;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class AuditingJobService
 *
 * This service class is responsible for handling auditing jobs.
 */
class AuditingJobService
{

    /**
     * @var AuditorService
     */
    protected AuditorService $auditorService;

    /**
     * AuditingJobService constructor.
     *
     * @param AuditorService $auditorService
     */
    public function __construct(
        AuditorService $auditorService
    )
    {
        $this->auditorService = $auditorService;
    }

    /**
     * Get all available auditing jobs.
     *
     * @return Collection
     */
    public function getAvailableJobs(): Collection
    {
        return AuditingJob::isAvailable()->get();
    }

    /**
     * Check if a specific job is available.
     *
     * @param $jobId
     * @return bool
     */
    public function isJobAvailable($jobId): bool
    {
        return AuditingJob::isAvailable()->where('id', $jobId)->exists();
    }

    /**
     * Assign a job to an auditor.
     *
     * @param $jobId
     * @param array $jobRequest
     * @return bool
     */
    public function assignJob($jobId, array $jobRequest): bool
    {
        $jobRequest['timezone_shift'] = $this->auditorService->getTimezoneShift($jobRequest['auditor_id']);
        $jobRequest['status'] = Status::IN_PROGRESS;

        DB::transaction(function () use ($jobId, $jobRequest) {
            $this->createAssessment($jobId, $jobRequest);
            $this->updateJobStatus($jobId, $jobRequest);
            $this->addToSchedule($jobId, $jobRequest);
        });

        return true;
    }

    /**
     * Create an assessment for a job.
     *
     * @param $jobId
     * @param array $jobRequest
     */
    protected function createAssessment($jobId, array $jobRequest): void
    {
        $assessment = new Assessment([
            'auditor_id' => $jobRequest['auditor_id'],
            'auditing_job_id' => $jobId,
            'assessment_date' => date('Y-m-d'),
            'note' => $jobRequest['note'],
            'created_at' => now()->tz($jobRequest['timezone_shift'])
        ]);
        $assessment->save();
    }

    /**
     * Update the status of a job.
     *
     * @param $jobId
     * @param $jobRequest
     */
    protected function updateJobStatus($jobId, $jobRequest): void
    {
        $job = AuditingJob::findOrFail($jobId);
        $job->update([
            'status' => $jobRequest['status'],
            'updated_at' => now()->tz($jobRequest['timezone_shift'])
        ]);
    }

    /**
     * Add a job to the auditor's schedule.
     *
     * @param $jobId
     * @param array $jobRequest
     */
    protected function addToSchedule($jobId, array $jobRequest): void
    {
        $schedule = new Schedule([
            'auditor_id' => $jobRequest['auditor_id'],
            'auditing_job_id' => $jobId,
            'scheduled_date' => $jobRequest['scheduled_date'],
            'created_at' => now()->tz($jobRequest['timezone_shift']),
        ]);
        $schedule->save();
    }

    /**
     * Check if a job is in progress and belongs to a specific auditor.
     *
     * @param $jobId
     * @param $auditorId
     * @return bool
     */
    public function isJobInProgressAndBelongsToAuditor($jobId,$auditorId): bool
    {
        return Schedule::with('auditingJob')
                ->whereHas('auditingJob', function ($query) {
                    $query->isInProgress();
                })
                ->where('auditing_job_id', $jobId)
                ->where('auditor_id', $auditorId)
            ->exists();
    }

    /**
     * Complete a job.
     *
     * @param $jobId
     * @param array $jobRequest
     * @return bool
     */
    public function completeJob($jobId, array $jobRequest): bool
    {
        $jobRequest['timezone_shift'] = $this->auditorService->getTimezoneShift($jobRequest['auditor_id']);
        $jobRequest['status'] = Status::COMPLETED;

        DB::transaction(function () use ($jobId, $jobRequest) {
            $this->createAssessment($jobId, $jobRequest);
            $this->updateJobStatus($jobId, $jobRequest);
            $this->completeSchedule($jobId, $jobRequest);
        });

        return true;
    }

    /**
     * Mark a job as completed in the auditor's schedule.
     *
     * @param $jobId
     * @param array $jobRequest
     */
    public function completeSchedule($jobId, array $jobRequest): void
    {
        $schedule = Schedule::where('auditing_job_id', $jobId)->where('auditor_id', $jobRequest['auditor_id'])->first();
        $schedule->update([
            'completed_date' => now()->tz($jobRequest['timezone_shift']),
            'updated_at' => now()->tz($jobRequest['timezone_shift'])
        ]);
    }

    /**
     * Get all jobs in progress.
     *
     * @return Collection
     */
    public function getJobsInProgress(): Collection
    {
        return Schedule::with('auditingJob')
            ->with('auditor')
            ->whereHas('auditingJob', function ($query) {
            $query->isInProgress();
        })->get();
    }

    /**
     * Get all completed jobs.
     *
     * @return Collection
     */
    public function getCompletedJobs(): Collection
    {
       $completedJobs = Schedule::with('auditingJob')
           ->with('auditor')
           ->with('auditingJob.assessments')
           ->whereHas('auditingJob', function ($query) {
               $query->isCompleted();
           })->get();


        // Modify each auditingJob to include assessments as a string
        $completedJobs->transform(function ($completedJob) {
            $completedJob->assessment = $completedJob->auditingJob->assessments->transform(function ($assessment) {
                return 'Assessed at:'.$assessment->assessment_date.' - '. $assessment->note;
            })->implode("<br>");

            return $completedJob;
        });

        return $completedJobs;
    }
}
