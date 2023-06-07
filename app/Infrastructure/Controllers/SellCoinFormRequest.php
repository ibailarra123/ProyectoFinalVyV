<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Exception;

class SellCoinFormRequest extends BaseController
{
    private function validacionIncorrecta(): JsonResponse
    {
        return response()->json([
            'status' => 'Error',
            'message' => 'Error parametros incorrectos',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function __invoke(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'coin_id' => ['required', 'max:255'],
            'wallet_id' => ['required', 'max:255'],
            'amount_usd' => ['required', 'max:255']
        ]);

        if ($validator->fails()) {
            return $this->validacionIncorrecta();
        }

        $coinId = request()->get('coin_id');
        $walletId = request()->get('wallet_id');
        $amountUsd = request()->get('amount_usd');

        $controller = new SellCoinController();

        try {
            $controller->venderCoin($coinId, $walletId, $amountUsd);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => 'Ok',
            'message' => 'Venta realizada correctamente',
        ], Response::HTTP_OK);
    }
}
