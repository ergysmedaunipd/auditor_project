<?php
namespace App\Enums\AuditingJobs;

/**
 * Class Status
 *
 * This class defines constants for different statuses of auditing jobs.
 * It also provides a method to get all the statuses.
 */
class Status
{
    // The job is scheduled but not yet started
    const SCHEDULED = 'scheduled';

    // The job is currently in progress
    const IN_PROGRESS = 'in_progress';

    // The job has been completed
    const COMPLETED = 'completed';

    /**
     * Get all statuses
     *
     * This method returns an array of all the statuses defined in this class.
     *
     * @return array An array of all statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::SCHEDULED,
            self::IN_PROGRESS,
            self::COMPLETED,
        ];
    }
}
