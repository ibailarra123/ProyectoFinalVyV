<?php

namespace App\Infrastructure\Controllers;

use App\Application\SellCoinService;
use Exception;

class SellCoinController
{
    /**
     * @throws Exception
     */
    public function venderCoin(string $coinId, string $walletId, float $amountUsd): void
    {
        $coinService = new SellCoinService();

        $coinService->execute($coinId, $walletId, $amountUsd);
    }
}
