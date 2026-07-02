<?php

namespace App\Helpers;

use App\DTO\AbstractpaginationDTO;

class ApiResponse
{
    public static function success($data = null, $message = "Success", $code = 200) {
        return response()->json([
            'error' => false,
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error(int $code, string $status,?string $message = "Somthing went wrong") {
        return response()->json([
            'error' => true,
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], $code);
    }

    public static function exception(\Exception $e): \Illuminate\Http\JsonResponse
    {
        // Handle Laravel validation exceptions specifically
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'error'   => true,
                'status'  => 'error',
                'message' => $e->getMessage(),
                'errors'  => $e->errors(),   // field-level errors e.g. {"name": ["The name field is required."]}
                'data'    => null
            ], 422);
        }

        // Fallback for all other exceptions
        return self::error(
            $e->getCode() ?: 500,
            'error',
            $e->getMessage() ?: 'Something went wrong'
        );
    }

    public static function flex($object = null, $message = null, $statusCode = null){
        $statusCode = $statusCode
            ?? $object->statusCode
            ?? $object?->data?->statusCode
            ?? 200;

        $data = $object->data ?? $object;

        if(is_object($data) && isset($data->statusCode)) unset($data->statusCode);
        if(is_array($data) && isset($data['statusCode'])) unset($data['statusCode']);

        $statusText = match(true) {
            $statusCode >= 200 && $statusCode < 300 => 'OK',
            $statusCode >= 300 && $statusCode < 400 => 'Client Error',
            $statusCode >= 500 => 'Server Error',
            default => 'Unknown',
        };

        $response = [
            'error' => $object->error ?? false,
            'status' => $statusText,
            'message' => $message ?? ($object->message ?? null),
            'data' => $data
        ];

        return response()->json($response, $statusCode);
    }

    public static function paginate(AbstractpaginationDTO $pagination, $message = null, $statusCode = 200)
    {
        $statusText = match(true) {
            $statusCode >= 200 && $statusCode < 300 => 'OK',
            $statusCode >= 400 && $statusCode < 500 => 'Client Error',
            $statusCode >= 500 => 'Server Error',
            default => 'Unknowm'
        };

        $response = [
            'error' => false,
            'status' => $statusText,
            'message' => $message,
            'pagination' => [
                'perPage' => $pagination->perPage,
                'total' => $pagination->total,
                'totalPage' => $pagination->totalPage,
                'pageNo' => $pagination->pageNo,
            ],
            'data' => $pagination->data,
        ];
        return response()->json($response, $statusCode);
    }

    public static function ManyRequest($err_msg = 'Too many requests', $errors = [])
    {
        return response()->json([
            'error'   => true,
            'status'  => 'Too Many Requests', // <-- correct label
            'errors'  => $errors,
            'message' => $err_msg,
        ], 429);
    }
}
