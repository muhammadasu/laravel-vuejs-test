<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Defined success response format
     * @param $message
     * @param $response
     * @return JsonResponse
     */
    public static function successResponse($message, $response = null): JsonResponse
    {
        return response()->json([
        'status' => true,
        'message' => $message,
        'data' => $response
        ]);
    }

    /**
     * Defined failure response format
     * @param $message
     * @param $response
     * @param int $code
     * @return JsonResponse
     */
    public static function failureResponse($message, $response = null, int $code = 403): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $response
        ], $code);
    }

    /**
     * Defined validation response
     * @param $message
     * @param $response
     * @return JsonResponse
     */
    public static function validationFailure($message, $response): JsonResponse
    {
        return response()->json([
        'status' => false,
        'message' => $message,
        'data' => $response
        ], 422);
    }

    public static function customArrayResponse($status, $code, $message, $response): array
    {
        return [
        'status' => $status,
        'code' => $code,
        'message' => $message,
        'data' => $response
        ];
    }
}
