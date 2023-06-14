<?php

namespace App\Infrastructure\Controllers;

use App\Application\CreateWalletService;
use Exception;
use Illuminate\Routing\Controller as BaseController;

class CreateWalletController extends BaseController
{
    /**
     * @throws Exception
     */
    public function crearWallet(string $userId): ?string
    {
        $walletService = new CreateWalletService();

        return $walletService->execute($userId);
    }
}
