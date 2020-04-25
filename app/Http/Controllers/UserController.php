<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthJwt;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;

class UserController extends Controller
{

    public function store(Request $request)
    {

        $dataUser = $request->only(['user', 'name', 'password', 'confirmPassword']);

        $sizeArray = count($dataUser);

        if ($sizeArray !== 4) {
            return response()
                ->json([
                    'message' => 'Por favor, envie todos os dados para ser salvo.',
                    'data' => new Object_()]
                    , 400);

        }

        if (!$dataUser['password'] ||
            $dataUser['password'] !== $dataUser['confirmPassword']) {

            return response()
                ->json([
                    'message' => 'Os dados da senha e confirma senha não são iguais.',
                    'data' => new Object_()]
                    , 400);

        }
        $existUser = User::where('user', $dataUser['user'])->first();

        if ($existUser) {
            return response()
                ->json([
                    'message' => 'O numero de usuário já existe.',
                    'data' => new Object_()],
                    400);
        }

        $user = new User();

        $user->name = $dataUser['name'];
        $user->user = $dataUser['user'];
        $user->password = $dataUser['password'];
        $user->role = 0;

        $user->save();

        $token = (new AuthJwt($request))->sign($user['id']);

        print_r($token);

        $data = [
            'user' => $user['user'],
            'name' => $user['name'],
            'role' => $user['role'],
            'token' => $token,
        ];

        return response()
            ->json(['message' => 'success', 'data' => $data], 201);
    }
}
