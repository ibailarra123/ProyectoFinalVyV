<?php

namespace App\Infrastructure\Persistence;

use App\Application\UserDataSource\WalletDataSource;
use App\Domain\User;
use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;

class FileWalletDataSource implements WalletDataSource
{
    public function create(string $userId): Wallet
    {
        $wallet = new Wallet(intval($userId));

        $this->addWallet($wallet);

        return $wallet;
    }
    public function addWallet(Wallet $wallet): bool
    {
        $wallets = $this->getAll();
        $wallets[$wallet->getUserId()] = $wallet;

        return Cache::forever("wallets", $wallets);
    }
    public function getAll(): array
    {
        return Cache::get("wallets") != null ? Cache::get("wallets") : array();
    }

    public function findById(string $id): ?Wallet
    {
        $wallets = $this->getAll();



        return $wallets != null && array_key_exists($id, $wallets) ? $wallets[$id] : null;
    }
}
