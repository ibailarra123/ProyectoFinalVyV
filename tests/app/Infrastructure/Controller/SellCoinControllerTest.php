<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\Coin;
use App\Domain\User;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\ApiCoinDataSource;
use App\Infrastructure\Persistence\FileUserDataSource;
use App\Infrastructure\Persistence\FileWalletDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class SellCoinControllerTest extends TestCase
{
    /**
     * @test
     */
    public function requestConParametrosIncorrectosDevuelveError()
    {
        $body = [
            'faskldk' => '1234'
        ];
        $response = $this->post('/api/coin/sell', $body);

        $response->assertExactJson(['status' => 'Error', 'message' => 'Parametros incorrectos']);
    }

    /**
     * @test
     */
    public function requestConWalletIdIncorrectoDevuelveError()
    {
        $body = [
            'coin_id' => '90',
            'wallet_id' => '1',
            'amount_usd' => 1500
        ];
        $response = $this->post('/api/coin/sell', $body);

        $response->assertExactJson(['status' => 'Error', 'message' => 'Wallet no existe']);
    }

    /**
     * @test
     */
    public function requestCorrectaDevuelveWalletId()
    {
        $walletDataSource = new FileWalletDataSource();
        $apiCoin = new ApiCoinDataSource();
        $wallet = new Wallet("1234");

        $wallet->addCoin($apiCoin->getById('90', 1500));

        $walletDataSource->addWallet($wallet);
        $body = [
            'coin_id' => '90',
            'wallet_id' => $wallet->getId(),
            'amount_usd' => 1500
        ];
        $response = $this->post('/api/coin/sell', $body);

        $response->assertJsonFragment([
            'status' => 'OK'
        ]);
    }
}
