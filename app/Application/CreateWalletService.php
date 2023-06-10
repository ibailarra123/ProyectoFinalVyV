<?php

namespace App\Application;

use App\Domain\Wallet;
use App\Infrastructure\Persistence\FileUserDataSource;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;
use PhpParser\Node\Scalar\String_;
use Tests\app\Infrastructure\Controller\WalletDataSourceTest;

class CreateWalletService
{
    /**
     * @throws Exception
     */
    public function execute(string $userId): ?string
    {
        $userDataSource = new FileUserDataSource();
        $walletDataSource = new FileWalletDataSource();

        if ($userDataSource->findById($userId) == null) {
            throw new Exception('Usuario no existe');
        }

        $wallet = $walletDataSource->create($userId);

        return strval($wallet->getId());
    }
}
