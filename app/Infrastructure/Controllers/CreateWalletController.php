<?php

namespace App\Infrastructure\Controllers;

use App\Application\CreateWalletService;
use Illuminate\Routing\Controller as BaseController;

class CreateWalletController extends BaseController
{
    /**
     * @throws \Exception
     */
    public function crearWallet(String $userId): ?String
    {
        $walletService = new CreateWalletService();

        $walletId =  $walletService->execute($userId);

        return $walletId;
    }
}
