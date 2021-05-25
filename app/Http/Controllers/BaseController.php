<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function errorResponse($message, $status = 500)
    {
        $payload = [
            'status' => 'error',
            'message' => $message
        ];
        return new JsonResponse($payload, $status);
    }

    public function successResponse($message, $status = 200)
    {

        $payload = [
            'status' => 'success',
            'data' => $message
        ];
        return new JsonResponse($payload, $status);
    }

    public function exceptionResponse(\Exception $exception)
    {
        $payload = [
            'status' => 'error',
            'message' => $exception->getMessage()
        ];
        return new JsonResponse($payload, 500);
    }
}
