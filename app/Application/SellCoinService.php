<?php

namespace App\Application;

use App\Domain\Coin;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\ApiCoinDataSource;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;

class SellCoinService
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
            throw new Exception('Wallet no existe');
        }

        $coin = $apiDataSource->getById($coinId, $amountUsd);
        $oldCoin = $wallet->getCoin($coinId);
        $wallet->deleteCoin($oldCoin);

        $amountDifference = $oldCoin->getAmount() - $coin->getAmount();
        if ($amountDifference > 0) {
            $newCoin = new Coin(
                $coinId,
                $oldCoin->getName(),
                $oldCoin->getSymbol(),
                $amountDifference,
                $coin->getValueUsd()
            );
            $wallet->addCoin($newCoin);
        } elseif ($amountDifference < 0) {
            throw new Exception('Tienes ' .
                                            $oldCoin->getAmount() .
                                            ' monedas y quieres vender ' .
                                            $coin->getAmount());
        }
    }
}
