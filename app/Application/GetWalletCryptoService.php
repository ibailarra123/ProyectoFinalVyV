<?php

namespace App\Application;

use Illuminate\Http\JsonResponse;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;

class GetWalletCryptoService
{
    /**
     * @throws Exception
     */
    public function execute(string $walletId): JsonResponse
    {
        $walletDataSource = new FileWalletDataSource();

        $wallet = $walletDataSource->findById($walletId);
        if ($wallet == null) {
            throw new Exception('Wallet no existe');
        }

        $coins = $wallet->getCoins();
        $jsonContent = array();
        $jsonContent["status"] = "OK";

        foreach ($coins as $coin) {
            $jsonArrayContent = array();

            $jsonArrayContent["coin_id"] = $coin->getCoinId();
            $jsonArrayContent["name"] = $coin->getName();
            $jsonArrayContent["symbol"] = $coin->getSymbol();
            $jsonArrayContent["amount"] = $coin->getAmount();
            $jsonArrayContent["value_usd"] = $coin->getValueUsd();

            $jsonContent[] = $jsonArrayContent;
        }

        return response()->json($jsonContent);
    }
}
