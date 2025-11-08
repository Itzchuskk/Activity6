<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    protected function ok($data = null, int $status = 200): JsonResponse
    {
        return response()->json(['ok' => true, 'data' => $data], $status);
    }

    protected function fail($message, int $status = 400): JsonResponse
    {
        return response()->json(['ok' => false, 'error' => $message], $status);
    }
}
