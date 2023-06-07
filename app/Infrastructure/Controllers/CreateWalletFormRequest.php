<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class CreateWalletFormRequest extends BaseController
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
            'user_id' => ['required', 'max:255']
        ]);

        if ($validator->fails()) {
            return $this->validacionIncorrecta();
        }

        $userId = request()->get('user_id');

        $controller = new CreateWalletController();

        try {
            $walletId = $controller->crearWallet($userId);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => 'Ok',
            'message' => $walletId,
        ], Response::HTTP_OK);
    }
}
