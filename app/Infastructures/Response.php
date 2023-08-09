<?php 

namespace App\Infastructures;

class Response
{
    public static function successResponse($message, $data)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function errorResponse($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 422);
    }

    public static function responseObject($status, $data)
    {
        return response()->json([
            'status' => $status,
            'data' => $data
        ]);
    }

    public static function responseObjectWithMessage($status, $message, $data)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}
?>