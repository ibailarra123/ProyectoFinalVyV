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

class GetWalletCryptoControllerTest extends TestCase
{
    /**
     * @test
     */
    public function requestConParametrosIncorrectosDevuelveError()
    {
        $response = $this->get('/api/wallet/asdfsa');

        $response->assertExactJson(['status' => 'Error', 'message' => 'Error parametros incorrectos']);
    }

    /**
     * @test
     */
    public function requestConWalletIdIncorrectoDevuelveError()
    {
        $response = $this->get('/api/wallet/1');

        $response->assertExactJson(['status' => 'Error', 'message' => 'Error wallet no existe']);
    }

    /**
     * @test
     */
    public function requestCorrectaDevuelveWalletId()
    {
        $walletDataSource = new FileWalletDataSource();
        $wallet = new Wallet("1234");
        $walletDataSource->addWallet($wallet);
        $response = $this->get('/api/wallet/1234');

        $response->assertJsonFragment([
            'status' => 'OK'
        ]);
    }
}
