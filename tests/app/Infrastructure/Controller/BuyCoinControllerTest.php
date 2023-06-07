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

class BuyCoinControllerTest extends TestCase
{
    /**
     * @test
     */
    public function RequestConParametrosIncorrectosDevuelveError()
    {
        $body = [
            'faskldk' => '1234'
        ];
        $response = $this->post('/api/coin/buy', $body);

        $response->assertExactJson(['status' => 'Error', 'message' => 'Error parametros incorrectos']);
    }

    /**
     * @test
     */
    public function RequestConWalletIdIncorrectoDevuelveError()
    {
        $body = [
            'coin_id' => '90',
            'wallet_id' => '1',
            'amount_usd' => 1500
        ];
        $response = $this->post('/api/coin/buy', $body);

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
        $body = [
            'coin_id' => '90',
            'wallet_id' => '1234',
            'amount_usd' => 1500
        ];
        $response = $this->post('/api/coin/buy', $body);

        $response->assertJsonFragment([
            'status' => 'Ok'
        ]);
    }
}
