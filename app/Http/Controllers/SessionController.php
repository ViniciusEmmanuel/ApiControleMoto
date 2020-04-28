<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthJwt;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function store(Request $request)
    {
        $dataUser = $request->all(['userId', 'password']);

        $user = User::firstWhere('user', $dataUser['userId']);

        if (!$user) {
            return $this->createResponse('Usuário ou senha incorretos.', [], 401);
        }

        if (!User::comparePassword($user['password'], $dataUser['password'])) {
            return $this->createResponse('Usuário ou senha incorretos.', [], 401);
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
