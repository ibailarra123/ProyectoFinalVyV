<?php

namespace App\Infrastructure\Controllers;

use App\Application\SellCoinService;

class SellCoinController
{
    /**
     * @throws \Exception
     */
    public function venderCoin(String $coinId, String $walletId, float $amountUsd): void
    {
        $coinService = new SellCoinService();

        $coinService->execute($coinId, $walletId, $amountUsd);
    }
}
