<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function createResponse($message, $data, $code)
    {

        return response([
            'message' => (string) $message,
            'data' => $data],
            (int) $code);

    }

}
