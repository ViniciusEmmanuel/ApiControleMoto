<?php

namespace App\Http\Controllers;

use App\Models\Gasoline;
use App\Models\Maintenance;
use App\Services\AuthJwt;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{

    public function index(Request $request)
    {

        $dateAfter = $request->get('date_after');
        $dateBefore = $request->get('date_before');
        $motorcicleId = $request->get('motorcicle_id');
        $partId = $request->get('part_id');

        $maintenanceLists = Maintenance::findFormatTable($dateBefore, $dateAfter, $motorcicleId, $partId);

        return $this->createResponse('success', $maintenanceLists, 200);
    }

    public function store(Request $request)
    {

        $dataMaintenance = $request->only(['motorcicleId', 'partId', 'date', 'km', 'price', 'mechanic']);

        $sizeArray = count($dataMaintenance);

        if ($sizeArray !== 6) {
            return $this->createResponse(
                'Por favor, envie todos os dados para ser salvo.',
                [],
                400);

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
            return $this->createResponse('Id não encontrado.', [], 400);
        }

        $maintenance->delete();

        return response([], 204);
    }

}
