<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class GetWalletCryptoFormRequest extends BaseController
{
    public function __invoke($wallet_id): JsonResponse
    {
        try {
            $walletId = request()->get('wallet_id');
        }
        catch (ContainerExceptionInterface | NotFoundExceptionInterface $ex) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Error parametros incorrectos',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $controller = new GetWalletCryptoController();

        try {
            $response = $controller->obtenerCrypto($walletId);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }
}
