<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use App\Application\GetWalletCryptoService;
use Exception;
use Illuminate\Routing\Controller as BaseController;

class GetWalletCryptoController extends BaseController
{
    /**
     * @throws Exception
     */
    public function obtenerCrypto(string $walletId): JsonResponse
    {
        $walletService = new GetWalletCryptoService();

        return $walletService->execute($walletId);
    }
}
