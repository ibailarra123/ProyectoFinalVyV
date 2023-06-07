<?php

namespace App\Application;

use App\Domain\Wallet;
use App\Infrastructure\Persistence\ApiCoinDataSource;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;

class BuyCoinService
{
    /**
     * @throws Exception
     */
    public function execute(string $coinId, string $walletId, float $amountUsd): void
    {
        $walletDataSource = new FileWalletDataSource();
        $apiDataSource = new ApiCoinDataSource();

        $wallet = $walletDataSource->findById($walletId);
        if ($wallet == null) {
            throw new Exception('Error wallet no existe');
        }

        $coin = $apiDataSource->getById($coinId, $amountUsd);
        $wallet->addCoin($coin);
    }
}
