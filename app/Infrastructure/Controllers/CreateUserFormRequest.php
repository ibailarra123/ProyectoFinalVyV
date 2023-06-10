<?php

namespace App\Infrastructure\Controllers;

use App\Application\CreateUserService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Exception;

class CreateUserFormRequest extends BaseController
{
    private function validacionIncorrecta(): JsonResponse
    {
        return response()->json([
            'status' => 'Error',
            'message' => 'Error parametros incorrectos',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function __invoke($userId, $email): JsonResponse
    {
        if (!is_numeric($userId)) {
            return $this->validacionIncorrecta();
        }

        $controller = new CreateUserController();

        try {
            $controller->crearUsuario($userId, $email);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status' => 'Ok',
            'message' => $userId,
        ], Response::HTTP_OK);
    }
}
