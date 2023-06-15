<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Persistence\FileUserDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class CreateUserControllerTest extends TestCase
{
    /**
     * @test
     */
    public function requestConParametrosIncorrectosDevuelveError()
    {
        $expectedResponse = ['status' => 'Error', 'message' => 'Parametros incorrectos'];

        $response = $this->get('/api/user/open/texto/1');

        $response->assertExactJson($expectedResponse);
    }

    /**
     * @test
     */
    public function requestConUserIdRepetidoDevuelveError()
    {
        $expectedResponse = ['status' => 'Error', 'message' => 'El usuario ya existe'];

        $userDataSource = new FileUserDataSource();
        $userDataSource->addUser(new User(12, "email@email,com"));

        $response = $this->get('/api/user/open/12/email@email.com');

        $response->assertExactJson($expectedResponse);
    }

    /**
     * @test
     */
    public function requestCorrectaDevuelveUserId()
    {
        $expectedResponse = [
            'status' => 'Ok',
            'message' => 'Creado usuario con id: 232323'
        ];

        $response = $this->get('/api/user/open/232323/email@email.com');

        $response->assertJsonFragment($expectedResponse);
    }
}
