<?php

namespace App\Http\Controllers;

use App\Models\Motorcicle;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;

class MotorcicleController extends Controller
{

    public function index()
    {
        $motorcicles = Motorcicle::all();

        return $this->createResponse('success', $motorcicles, 200);
    }

    public function store(Request $request)
    {
        $motorcicle = new Motorcicle();

        $dataMoto = $request->only(['board', 'description']);

        $sizeArray = count($dataMoto);

        if ($sizeArray < 1) {
            return response()
                ->json([
                    'message' => 'Por favor, envie todos os dados para ser salvo.',
                    'data' => new Object_()]
                    , 400);

        }

        $motorcicle['board'] = $dataMoto['board'];

        if (array_key_exists('descrition', $dataMoto)) {
            $motorcicle['description'] = $dataMoto['descrition'];
        }

        $motorcicle->save();

        return response([
            'message' => 'success',
            'data' => $motorcicle],
            200);
    }

    public function destroy(Request $request, $id)
    {

        $motorcicle = Motorcicle::where('id', (int) $id)->first();

        if (!$motorcicle) {
            return response([
                'messsage' => 'Moto não encontrada.',
                'data' => new Object_()],
                400);
        }

        $motorcicle->delete();

        return response([], 204);
    }

}
