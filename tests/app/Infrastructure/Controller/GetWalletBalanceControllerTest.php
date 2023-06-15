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

class GetWalletBalanceControllerTest extends TestCase
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
        $response = $this->get('/api/wallet/asdfs/balance');

        $response->assertExactJson(['status' => 'Error', 'message' => 'Parametros incorrectos']);
    }

    /**
     * @test
     */
    public function requestConWalletIdIncorrectoDevuelveError()
    {
        $expectedResponse = ['status' => 'Error', 'message' => 'Wallet no existe'];
        $this->walletCache->shouldReceive("findById")->andReturn(null);
        $this->app->instance(WalletDataSource::class, $this->walletCache);

        $response = $this->get('/api/wallet/-1/balance');

        $response->assertExactJson($expectedResponse);
    }

    /**
     * @test
     */
    public function requestCorrectaDevuelveWalletId()
    {
        $walletDataSource = new FileWalletDataSource();
        $wallet = new Wallet(1234);
        $walletDataSource->addWallet($wallet);
        $response = $this->get('/api/wallet/' . $wallet->getId() . '/balance');

        $response->assertJsonFragment([
            'status' => 'OK'
        ]);
    }
}
