<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Persistence\FileUserDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class UserDataSourceTest extends TestCase
{
    /**
     * @test
     */
    public function findUserById()
    {
        $id = "1";
        $email = "prueba@gmail.com";
        $user = new User($id, $email);
        $data_source = new FileUserDataSource();
        $new_data_source = new FileUserDataSource();

        $data_source->addUser($user);
        $result = $new_data_source->findById($id);

        self::assertEquals($result, $user);
    }

    /**
     * @test
     */
    public function findUserByEmail()
    {
        $id = "1";
        $email = "prueba@gmail.com";
        $user = new User($id, $email);
        $data_source = new FileUserDataSource();
        $new_data_source = new FileUserDataSource();

        $data_source->addUser($user);
        $result = $new_data_source->findByEmail($email);

        self::assertEquals($result, $user);
    }
}
