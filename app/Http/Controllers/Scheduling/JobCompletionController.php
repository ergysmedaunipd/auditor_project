<?php

namespace App\Http\Controllers\Scheduling;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteJobRequest;
use App\Services\AuditingJobService;
use Illuminate\Http\JsonResponse;

class JobCompletionController extends Controller
{
    /**
     * @var AuditingJobService
     *
     * The service that will be used to interact with the Auditing Jobs data.
     */
    protected AuditingJobService $auditingJobService;

    /**
     * JobCompletionController constructor.
     *
     * @param AuditingJobService $auditingJobService
     *
     */
    public function __construct(
        AuditingJobService $auditingJobService
    )
    {
        $this->auditingJobService = $auditingJobService;
    }

    /**
     * The index method.
     *
     * @OA\Get(
     *     path="/api/auditors/jobs_to_complete",
     *     @OA\Response(response="200", description="List of jobs in progress")
     * )
     *
     * It retrieves all jobs in progress using the AuditingJobService and returns them as a JSON response.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return ResponseHelper::jsonResponse($this->auditingJobService->getJobsInProgress());
    }

    /**
     * The update method.
     *
     *
     *
     * @OA\Post(
     *      path="/api/auditors/{jobId}/complete",
     *      @OA\Parameter(
     *          name="jobId",
     *          in="path",
     *          description="The ID of the job to be completed",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"auditor_id"},
     *              @OA\Property(property="auditor_id", type="integer", example="1"),
     *              @OA\Property(property="note", type="string", example="This is a note")
     *          )
     *      ),
     *      @OA\Response(response="200", description="Job Compelted successfully"),
     *  )
     *
     *
     * This method is responsible for handling requests to the update route.
     * It validates the request, checks if the job is in progress and belongs to the auditor,
     * completes the job if it is in progress and belongs to the auditor,
     * and returns a JSON response indicating the result of the operation.
     *
     * @param CompleteJobRequest $request The request object containing the data for the job completion.
     * @param int $jobId The ID of the job to be completed.
     *
     * @return JsonResponse A JSON response indicating the result of the operation.
     */

    public function update(CompleteJobRequest $request, int $jobId): JsonResponse
    {
        $jobRequest = $request->validated();
        // Check that job exists and is available
        if (!$this->auditingJobService->isJobInProgressAndBelongsToAuditor($jobId, $jobRequest['auditor_id'])){
            return ResponseHelper::jsonResponse(['message' => 'Job not available'], 400);
        }

        $completed = $this->auditingJobService->completeJob($jobId, $jobRequest);
        if (!$completed) {
            return ResponseHelper::jsonResponse(['message' => 'Job completion failed'], 500);
        }

        return ResponseHelper::jsonResponse(['message' => 'Job is completed successfully']);
    }
}
