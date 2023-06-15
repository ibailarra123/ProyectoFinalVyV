<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Persistence\FileUserDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class CreateWalletControllerTest extends TestCase
{
    private $mockery;
    private $userCache;


    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockery = new Mockery();
        $this->userCache = $this->mockery::mock(FileUserDataSource::class);
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
        $response = $this->post('/api/wallet/open', $body);

        $response->assertExactJson($expectedResponse);
    }

    /**
     * @test
     */
    public function requestConUserIdIncorrectoDevuelveError()
    {
        $expectedResponse = ['status' => 'Error', 'message' => 'Usuario no existe'];
        $this->userCache->shouldReceive("findById")->andReturn(null);
        $this->app->instance(UserDataSource::class, $this->userCache);
        $body = [
            'user_id' => '1234'
        ];
        $response = $this->post('/api/wallet/open', $body);

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
        $userDataSource = new FileUserDataSource();
        $userDataSource->addUser(new User(1, "prueba@prueba,com"));
        $body = [
            'user_id' => '1'
        ];
        $response = $this->post('/api/wallet/open', $body);

        $response->assertJsonFragment($expectedResponse);
    }
}
