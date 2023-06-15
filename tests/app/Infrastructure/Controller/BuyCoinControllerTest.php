<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Application\UserDataSource\WalletDataSource;
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
    private $mockery;
    private $walletCache;


    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockery = new Mockery();
        $this->walletCache = $this->mockery::mock(FileWalletDataSource::class);
    }

    /**
     * @test
     */
    public function requestConParametrosIncorrectosDevuelveError()
    {
        $expectedResponse = ['status' => 'Error', 'message' => 'Parametros incorrectos'];
        $body = [
            'faskldk' => '1234'
        ];

        $response = $this->post('/api/coin/buy', $body);

        $response->assertExactJson($expectedResponse);
    }

    /**
     * @test
     */
    public function requestConWalletIdIncorrectoDevuelveError()
    {
        $expectedResponse = ['status' => 'Error', 'message' => 'Wallet no existe'];
        $this->walletCache->shouldReceive("findById")->andReturn(null);
        $this->app->instance(WalletDataSource::class, $this->walletCache);
        $body = [
            'coin_id' => '90',
            'wallet_id' => '1',
            'amount_usd' => 1500
        ];

        $response = $this->post('/api/coin/buy', $body);

        $response->assertExactJson($expectedResponse);
    }

    /**
     * @test
     */
    public function requestCorrectaDevuelveWalletId()
    {
        $expectedResponse = [
            'status' => 'Ok'
        ];
        $walletDataSource = new FileWalletDataSource();
        $wallet = new Wallet("1234");
        $walletDataSource->addWallet($wallet);
        $body = [
            'coin_id' => '90',
            'wallet_id' => $wallet->getId(),
            'amount_usd' => 1500
        ];

        $response = $this->post('/api/coin/buy', $body);

        $response->assertJsonFragment($expectedResponse);
    }
}
