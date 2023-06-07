<?php

namespace App\Application;

use Illuminate\Http\JsonResponse;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;
use Illuminate\Http\Response;

class GetWalletBalanceService
{
    /**
     * @throws Exception
     */
    public function execute(string $walletId): JsonResponse
    {
        $walletDataSource = new FileWalletDataSource();

        $wallet = $walletDataSource->findById($walletId);
        if ($wallet == null) {
            throw new Exception('Error wallet no existe');
        }

        $coins = $wallet->getCoins();
        $balanceUSD = 0;

        foreach ($coins as $coin) {
            $balanceUSD += $coin->getValueUsd();
        }

        return response()->json([
            'status' => 'OK',
            'message' => $balanceUSD,
        ], Response::HTTP_OK);
    }
}
