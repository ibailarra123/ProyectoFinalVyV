<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\FileUserDataSource;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class GetWalletBalanceControllerTest extends TestCase
{
    /**
     * @test
     */
    public function RequestConParametrosIncorrectosDevuelveError()
    {
        $response = $this->get('/api/wallet/balance');

        $response->assertExactJson(['status' => 'Error', 'message' => 'Error parametros incorrectos']);
    }

    /**
     * @test
     */
    public function RequestConWalletIdIncorrectoDevuelveError()
    {
        $response = $this->get('/api/wallet/1/balance');

        $response->assertExactJson(['status' => 'Error', 'message' => 'Error wallet no existe']);
    }

    /**
     * @test
     */
    public function RequestCorrectaDevuelveWalletId()
    {
        $walletDataSource = new FileWalletDataSource();
        $wallet = new Wallet("1234");
        $walletDataSource->addWallet($wallet);
        $response = $this->get('/api/wallet/1234/balance');

        $response->assertJsonFragment([
            'status' => 'Ok'
        ]);
    }
}
