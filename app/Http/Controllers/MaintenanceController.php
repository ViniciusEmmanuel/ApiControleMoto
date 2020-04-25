<?php

namespace App\Http\Controllers;

use App\Models\Gasoline;
use App\Models\Maintenance;
use App\Services\AuthJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;

class MaintenanceController extends Controller
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

        $maintenanceLists = DB::select("select * from view_maintenance vm" . $where, $binds);

        return $this->createResponse('success', $maintenanceLists, 200);
    }

    public function store(Request $request)
    {

        $dataMaintenance = $request->only(['motorcicleId', 'partId', 'date', 'km', 'price', 'mechanic']);

        $sizeArray = count($dataMaintenance);

        if ($sizeArray !== 6) {
            return $this->createResponse(
                'Por favor, envie todos os dados para ser salvo.',
                new Object_()
                , 400);

        }

        $maintenance = new Maintenance();

        $maintenance->user_id = (string) (new AuthJwt($request))->getUser();
        $maintenance->motorcicle_id = (int) $dataMaintenance['motorcicleId'];
        $maintenance->part_id = (int) $dataMaintenance['partId'];
        $maintenance->date = $dataMaintenance['date'];
        $maintenance->km = (float) $dataMaintenance['km'];
        $maintenance->price = (float) $dataMaintenance['price'];
        $maintenance->mechanic = (string) $dataMaintenance['mechanic'];

        $maintenance->save();

        return $this->createResponse('success', $maintenance, 201);
    }

    public function destroy(Request $request, $id)
    {

        $maintenance = Gasoline::where('id', (int) $id)->first();

        if (!$maintenance) {
            return $this->createResponse('Id não encontrado.', new Object_(), 400);
        }

        $maintenance->delete();

        return response([], 204);
    }

}
