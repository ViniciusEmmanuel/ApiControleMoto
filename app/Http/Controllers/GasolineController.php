<?php

namespace App\Http\Controllers;

use App\Models\Gasoline;
use App\Services\AuthJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;

class GasolineController extends Controller
{

    public function index(Request $request)
    {

        $dateAfter = $request->get('date_after');
        $dateBefore = $request->get('date_before');
        $partId = $request->get('part_id');
        $motorcicleId = $request->get('motorcicle_id');

        $where = ' ' . 'where 1 = ?';

        $binds = [1];

        if ($partId) {
            $where .= ' ' . 'and vm.part_id = ?';
            array_push($binds, (int) $partId);
        }

        if ($dateAfter && $dateBefore) {
            $where .= ' ' . 'and vm.date between date(?) and date(?)';
            array_push($binds, $dateBefore);
            array_push($binds, $dateAfter);
        }

        if ($motorcicleId) {
            $where .= ' ' . 'and vm.motorcicle_id = ?';
            array_push($binds, $motorcicleId);
        }

        $gasolineLists = DB::select("select * from view_gasoline vg" . $where, $binds);

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
            return $this->createResponse('Id não encontrado.', new Object_(), 400);
        }

        $gasoline->delete();

        return response([], 204);
    }

}
