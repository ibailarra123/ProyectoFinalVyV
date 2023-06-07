<?php

namespace App\Infrastructure\Controllers;

use App\Application\BuyCoinService;
use Exception;
use Illuminate\Routing\Controller as BaseController;

class CoinBuyController extends BaseController
{
    /**
     * @throws Exception
     */
    public function comprarCoin(String $coinId, String $walletId, float $amountUsd): void
    {
        $coinService = new BuyCoinService();

        $coinService->execute($coinId, $walletId, $amountUsd);
    }
    //Prueba
    //Prueba2
}
