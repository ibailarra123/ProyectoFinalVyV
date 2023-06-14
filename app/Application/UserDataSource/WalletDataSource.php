<?php

namespace App\Application\UserDataSource;

use App\Domain\Wallet;

interface WalletDataSource
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
    public function findById(string $idWallet): ?Wallet;
}
