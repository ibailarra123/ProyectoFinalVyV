<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GetCoinSellController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status' => 'Ok',
            'message' => 'Systems are up and running',
        ], Response::HTTP_OK);
    }
}
