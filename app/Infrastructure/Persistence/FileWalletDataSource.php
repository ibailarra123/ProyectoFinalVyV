<?php

namespace App\Infrastructure\Persistence;

use App\Application\UserDataSource\WalletDataSource;
use App\Domain\User;
use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;

class FileWalletDataSource implements WalletDataSource
{
    private Cache $cache;
    public function __construct()
    {
        $this->cache = new Cache();
    }
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

        return $this->cache::forever("wallets", $wallets);
    }
    public function getAll(): array
    {
        return $this->cache::get("wallets") != null ? $this->cache::get("wallets") : array();
    }

    public function findById(string $walletId): ?Wallet
    {
        $wallets = $this->getAll();

        return $wallets != null && array_key_exists($walletId, $wallets) ? $wallets[$walletId] : null;
    }
}
