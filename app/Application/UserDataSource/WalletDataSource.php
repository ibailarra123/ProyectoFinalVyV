<?php

namespace App\Application\UserDataSource;

use App\Domain\Wallet;

Interface WalletDataSource
{
    /**
     * @return bool
     */
    public function addWallet(Wallet $wallet): bool;

    /**
     * @return Wallet[]
     */
    public function getAll(): array;

    /**
     * @return Wallet or null
     */
    public function findById(string $id): ?Wallet;
}
