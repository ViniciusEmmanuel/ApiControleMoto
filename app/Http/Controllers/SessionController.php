<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthJwt;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;

class SessionController extends Controller
{

    public function store(Request $request)
    {
        $dataUser = $request->all(['userId', 'password']);

        $user = User::firstWhere('user', $dataUser['userId']);

        if (!$user) {
            return response(
                ['message' => 'Usuário ou senha incorretos.',
                    'data' => new Object_()], 400);
        }

        if (!User::comparePassword($user['password'], $dataUser['password'])) {
            return response(
                ['message' => 'Usuário ou senha incorretos.',
                    'data' => new Object_()], 400);
        }

        $token = (new AuthJwt($request))->sign($user['id']);

        $data = [
            'user' => $user['user'],
            'name' => $user['name'],
            'role' => $user['role'],
            'token' => $token,
        ];

        return $this->createResponse('success', $data, 201);
    }
}
