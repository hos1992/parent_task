<?php

namespace App\Traits;

trait Responses
{

    /**
     * @param array $data
     * @param string $msg
     * @param int $httpStatus
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = [], $msg = 'Success', $httpStatus = 200)
    {
        return response()->json([
            'status' => 1,
            'message' => $msg,
            'data' => $data,
        ], $httpStatus);
    }

    /**
     * @param string $msg
     * @param int $httpStatus
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($msg = 'Error processing !', $httpStatus = 422)
    {
        return response()->json([
            'status' => 0,
            'message' => $msg,
        ], $httpStatus);
    }
}
