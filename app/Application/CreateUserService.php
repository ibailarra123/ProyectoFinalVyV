<?php

namespace App\Application;

use App\Domain\Wallet;
use App\Infrastructure\Persistence\FileUserDataSource;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;
use PhpParser\Node\Scalar\String_;
use Tests\app\Infrastructure\Controller\WalletDataSourceTest;

class CreateUserService
{
    /**
     * @throws Exception
     */
    public function execute(string $userId, string $email): ?string
    {
        $userDataSource = new FileUserDataSource();

        if ($userDataSource->findById($userId) != null) {
            throw new Exception('El usuario ya existe');
        }

        $user = $userDataSource->create($userId, $email);

        return strval($user->getId());
    }
}
