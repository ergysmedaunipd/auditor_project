<?php
namespace App\Helpers;


use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Create a JSON response
     *
     * This method creates a JSON response with the given data and status code.
     * If no status code is provided, it defaults to 200.
     *
     * @param mixed $data The data to be included in the response
     * @param int $statusCode The status code for the response
     * @return JsonResponse The created JSON response
     */
    public static function jsonResponse(mixed $data, int $statusCode = 200): JsonResponse
    {
        return response()->json($data, $statusCode);
    }
}
