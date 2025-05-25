<?php

namespace App\Helper;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function success($status = 'success', $message = '', $data = [], $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function error($status = 'error', $message = '', $statusCode = 500)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $statusCode);
    }
}