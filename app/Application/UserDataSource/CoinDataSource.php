<?php

namespace App\Application\UserDataSource;

use App\Domain\Coin;

interface CoinDataSource
{
    /**
     * @return Coin or null
     */
    public function getById(string $coinid, float $amountUSD): ?Coin;
}
