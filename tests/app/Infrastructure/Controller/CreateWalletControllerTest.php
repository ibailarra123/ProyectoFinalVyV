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
    public function RequestConParametrosIncorrectosDevuelveError()
    {
        $body = [
            'faskldk' => '1234'
        ];
        $response = $this->post('/api/wallet/open', $body);

        $response->assertExactJson(['status' => 'Error', 'message' => 'Error parametros incorrectos']);
    }

    /**
     * @test
     */
    public function RequestConUserIdIncorrectoDevuelveError()
    {
        $body = [
            'user_id' => '1234'
        ];
        $response = $this->post('/api/wallet/open', $body);

        $response->assertExactJson(['status' => 'Error', 'message' => 'Error usuario no existe']);
    }

    /**
     * @test
     */
    public function RequestCorrectaDevuelveWalletId()
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
