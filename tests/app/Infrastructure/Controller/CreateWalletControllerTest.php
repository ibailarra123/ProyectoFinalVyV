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
    /**
     * @test
     */
    public function requestConParametrosIncorrectosDevuelveError()
    {
        $body = [
            'faskldk' => '1234'
        ];
        $response = $this->post('/api/wallet/open', $body);

        $response->assertExactJson(['status' => 'Error', 'message' => 'Parametros incorrectos']);
    }

    /**
     * @test
     */
    public function requestConUserIdIncorrectoDevuelveError()
    {
        $body = [
            'user_id' => '1234'
        ];
        $response = $this->post('/api/wallet/open', $body);

        $response->assertExactJson(['status' => 'Error', 'message' => 'Usuario no existe']);
    }

    /**
     * @test
     */
    public function requestCorrectaDevuelveWalletId()
    {
        $userDataSource = new FileUserDataSource();
        $userDataSource->addUser(new User(1, "prueba@prueba,com"));
        $body = [
            'user_id' => '1'
        ];
        $response = $this->post('/api/wallet/open', $body);

        $response->assertJsonFragment([
            'status' => 'Ok'
        ]);
    }
}
