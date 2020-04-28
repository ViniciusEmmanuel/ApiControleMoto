<?php

namespace App\Http\Controllers;

use App\Models\Gasoline;
use App\Services\AuthJwt;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;

class GasolineController extends Controller
{

    public function index(Request $request)
    {

        $dateAfter = $request->get('date_after');
        $dateBefore = $request->get('date_before');
        $motorcicleId = $request->get('motorcicle_id');

        $gasolineLists = Gasoline::findFormatTable($dateBefore, $dateAfter, $motorcicleId);

        return $this->createResponse('success', $gasolineLists, 200);
    }

    public function store(Request $request)
    {

        $dataGasoline = $request->only(['motorcicleId', 'date', 'km', 'liters', 'price']);

        $sizeArray = count($dataGasoline);

        if ($sizeArray !== 5) {
            return response()
                ->json([
                    'message' => 'Por favor, envie todos os dados para ser salvo.',
                    'data' => new Object_()]
                    , 400);

        }

        $gasoline = new Gasoline();

        //'1a747163-7529-4b69-9917-760f8b162ab6';
        $gasoline->user_id = (string) (new AuthJwt($request))->getUser();
        $gasoline->motorcicle_id = (int) $dataGasoline['motorcicleId'];
        $gasoline->date = $dataGasoline['date'];
        $gasoline->km = (float) $dataGasoline['km'];
        $gasoline->liters = (float) $dataGasoline['liters'];
        $gasoline->price = (float) $dataGasoline['price'];

        $gasoline->save();

        return $this->createResponse('success', $gasoline, 201);
    }

    public function destroy(Request $request, $id)
    {

        $gasoline = Gasoline::where('id', (int) $id)->first();

        if (!$gasoline) {
            return $this->createResponse('Id não encontrado.', [], 400);
        }

        $gasoline->delete();

        return response([], 204);
    }

}
