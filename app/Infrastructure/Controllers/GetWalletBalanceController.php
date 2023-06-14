<?php

namespace App\Infrastructure\Controllers;

use App\Application\GetWalletBalanceService;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Routing\Controller as BaseController;

class GetWalletBalanceController extends BaseController
{
    /**
     * @throws Exception
     */
    public function obtenerBalance(string $walletId): JsonResponse
    {
        $walletService = new GetWalletBalanceService();

        return $walletService->execute($walletId);
    }
}
