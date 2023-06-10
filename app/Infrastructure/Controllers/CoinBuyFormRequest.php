<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Exception;

class CoinBuyFormRequest extends BaseController
{
    private function validacionIncorrecta(): JsonResponse
    {
        return response()->json([
            'status' => 'Error',
            'message' => 'Parametros incorrectos',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function __invoke(): JsonResponse
    {
        $validatorClass = new Validator();
        $validator = $validatorClass::make(request()->all(), [
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

        $controller = new CoinBuyController();

        try {
            $controller->comprarCoin($coinId, $walletId, $amountUsd);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => 'Ok',
            'message' => 'Comprada criptomoneda: ' . $coinId . ' en la cartera: ' . $walletId,
        ], Response::HTTP_OK);
    }
}
