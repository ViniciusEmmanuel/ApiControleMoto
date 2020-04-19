<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Object_;

class UserController extends Controller
{

    public function store(Request $request)
    {

        $dataUser = $request->only(['userId', 'name', 'password', 'confirmPassword']);

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

        $user = new User();

        $user->name = $dataUser['name'];
        $user->userId = $dataUser['userId'];
        $user->password = Hash::make($dataUser['password'], [
            'rounds' => 12,
        ]);
        $user->role = 0;

        $user->save();

        return response()
            ->json(['message' => 'success', 'data' => $user], 201);
    }
}
