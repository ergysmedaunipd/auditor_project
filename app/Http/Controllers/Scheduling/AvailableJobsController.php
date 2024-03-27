<?php

namespace App\Http\Controllers\Scheduling;

use App\Http\Controllers\Controller;
use App\Services\AuditingJobService;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;

class AvailableJobsController extends Controller
{
    /**
     * @var AuditingJobService
     *
     * The service that will be used to interact with the Auditing Jobs data.
     */
    protected AuditingJobService $auditingJobService;

    /**
     * AvailableJobsController constructor.
     *
     * @param AuditingJobService $auditingJobService
      */
    public function __construct(AuditingJobService $auditingJobService)
    {
        $this->auditingJobService = $auditingJobService;
    }

    /**
     * The index method.
     *
     * @OA\Get(
     *     path="/api/auditors/free_jobs",
     *     @OA\Response(response="200", description="List of available jobs")
     * )
     *
     * It retrieves all available auditing jobs using the AuditingJobService and returns them as a JSON response.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return ResponseHelper::jsonResponse($this->auditingJobService->getAvailableJobs());
    }
}
