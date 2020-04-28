<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartsController extends Controller
{

    public function index()
    {

        $parts = Part::all();

        return $this->createResponse('success', $parts, 200);

    }

    public function store(Request $request)
    {

        $part = new Part();

        $dataPart = $request->only(['name', 'description']);

        $sizeArray = count($dataPart);

        if ($sizeArray < 1) {
            return $this->createResponse('Por favor, envie todos os dados para ser salvo.', [], 400);

        }

        $part['name'] = $dataPart['name'];

        if (array_key_exists('descrition', $dataPart)) {
            $part['description'] = $dataPart['descrition'];
        }

        $part->save();

        return $this->createResponse('success', $part, 201);

    }
}
