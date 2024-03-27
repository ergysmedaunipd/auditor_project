<?php

namespace App\Http\Controllers\Scheduling;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignJobRequest;
use App\Services\AuditingJobService;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;

class JobAssignmentController extends Controller
{
    /**
     * @var AuditingJobService
     *
     * The service that will be used to interact with the Auditing Jobs data.
     */
    protected AuditingJobService $auditingJobService;

    /**
     * JobAssignmentController constructor.
     *
     * @param AuditingJobService $auditingJobService
     */
    public function __construct(
        AuditingJobService $auditingJobService
    )
    {
        $this->auditingJobService = $auditingJobService;
    }


    /**
     * The store method.
     *
     * @OA\Post(
     *     path="/api/auditors/{jobId}/assign",
     *     @OA\Parameter(
     *         name="jobId",
     *         in="path",
     *         description="The ID of the job to be assigned",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"auditor_id"},
     *             @OA\Property(property="auditor_id", type="integer", example="1"),
     *             @OA\Property(property="scheduled_date", type="string", format="date", example="2024-04-01"),
     *             @OA\Property(property="note", type="string", example="This is a note")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Assign a job to an auditor")
     * )
     *
     * It validates the request, checks if the job is available, assigns the job if it is available,
     * and returns a JSON response indicating the result of the operation.
     *
     * @param AssignJobRequest $request The request object containing the data for the job assignment.
     * @param int $jobId The ID of the job to be assigned.
     *
     * @return JsonResponse A JSON response indicating the result of the operation.
     */
    public function store(AssignJobRequest $request, int $jobId): JsonResponse
    {
        $jobRequest = $request->validated();

        // Check that job exists and is available
        if (!$this->auditingJobService->isJobAvailable($jobId)) {
            return ResponseHelper::jsonResponse(['message' => 'Job not available'], 400);
        }

        // Assign job to auditor
        $assigned = $this->auditingJobService->assignJob($jobId, $jobRequest);
        if (!$assigned) {
            return ResponseHelper::jsonResponse(['message' => 'Job assignment failed'], 500);
        }

        return ResponseHelper::jsonResponse(['message' => 'Job assigned successfully']);
    }
}
