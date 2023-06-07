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
    private function validacionIncorrecta(): JsonResponse
    {
        return response()->json([
            'status' => 'Error',
            'message' => 'Error parametros incorrectos',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function __invoke($walletId): JsonResponse
    {
        if (!is_numeric($walletId)) {
            return $this->validacionIncorrecta();
        }

        $controller = new GetWalletCryptoController();

        try {
            $response = $controller->obtenerCrypto($walletId);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }
}
