<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class WalletDataSourceTest extends TestCase
{
    /**
     * @test
     */
    public function findWalletById()
    {
        $userId = "1";
        $wallet = new Wallet($userId);
        $walletId = $wallet->getId();
        $data_source = new FileWalletDataSource();
        $new_data_source = new FileWalletDataSource();

        $data_source->addWallet($wallet);
        $result = $new_data_source->findById($walletId);

        self::assertEquals($result, $wallet);
    }
}
