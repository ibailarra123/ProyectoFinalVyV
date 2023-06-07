<?php

namespace App\Application;

use App\Domain\Wallet;
use App\Infrastructure\Persistence\FileUserDataSource;
use App\Infrastructure\Persistence\FileWalletDataSource;
use PhpParser\Node\Scalar\String_;
use Tests\app\Infrastructure\Controller\WalletDataSourceTest;

class CreateWalletService
{
    /**
     * @throws \Exception
     */
    public function execute(String $userId): ?String
    {
        $userDataSource = new FileUserDataSource();
        $walletDataSource = new FileWalletDataSource();

        if ($userDataSource->findById($userId) == null)
            throw new \Exception('Error usuario no existe');

        $wallet = $walletDataSource->create($userId);

        return strval( $wallet->getId() );
    }
}
