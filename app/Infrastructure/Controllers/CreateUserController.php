<?php

namespace App\Infrastructure\Controllers;

use App\Application\CreateUserService;
use App\Application\CreateWalletService;
use Exception;
use Illuminate\Routing\Controller as BaseController;

class CreateUserController extends BaseController
{
    /**
     * @throws Exception
     */
    public function crearUsuario(string $userId): void
    {
        $userService = new CreateUserService();

        $userService->execute($userId);
    }
}
