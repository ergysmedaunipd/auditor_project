<?php

namespace App\Http\Controllers\Auditing;

use App\Http\Controllers\Controller;
use App\Services\AuditorService;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseHelper;

class AuditorController extends Controller
{
    /**
     * @var AuditorService
     *
     * The service that will be used to interact with the Auditors data.
     */
    protected AuditorService $auditorService;

    /**
     * AuditorController constructor.
     *
     * @param AuditorService $auditorService
     */
    public function __construct(AuditorService $auditorService)
    {
        $this->auditorService = $auditorService;
    }

    /**
     * The index method.
     *
     * @OA\Get(
     *     path="/api/auditors",
     *     @OA\Response(response="200", description="List of auditors")
     * )
     *
     * It retrieves all Auditors using the AuditorService and returns them as a JSON response.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $auditors = $this->auditorService->getAllAuditors();

        return ResponseHelper::jsonResponse(response()->json($auditors));
    }
}
