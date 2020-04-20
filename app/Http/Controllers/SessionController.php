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

        $token = (new AuthJwt($request))->sign($user['id']);

        return response([
            'user' => $user['user'],
            'nome' => $user['name'],
            'token' => $token,
        ], 201);

    }
}
