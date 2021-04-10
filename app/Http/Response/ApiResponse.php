<?php


namespace App\Http\Response;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function error(?string $message, array $errors = [], int $http_code = 400): JsonResponse
    {
        return response()->json([
            'isOk' => false,
            'message' => $message,
            'errors' => $errors
        ], $http_code);
    }

    public static function success(array $data = [], int $http_code = 200): JsonResponse
    {
        return response()->json([
            'isOk' => true,
            'content' => $data
        ], $http_code);
    }

    public static function list(LengthAwarePaginator $data): JsonResponse
    {
        $response = ['isOk' => true];

        return response()->json($response += $data->toArray());
    }
}
