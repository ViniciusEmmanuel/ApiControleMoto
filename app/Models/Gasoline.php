<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gasoline extends Model
{

    protected $table = 'gasoline';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $hidden = ['user_id'];

    protected $user_id;

    protected $motorcicle_id;

    protected $date;

    protected $km;

    protected $liters;

    protected $price;

    protected $deleted;

    public static function findFormatTable($dateBefore, $dateAfter, $motorcicleId)
    {

        $where = ' ' . 'where 1 = ?';

        $binds = [1];

        if ($dateAfter && $dateBefore) {
            $where .= ' ' . 'and x.date between date(?) and date(?)';
            array_push($binds, $dateBefore);
            array_push($binds, $dateAfter);
        }

        if ($motorcicleId) {
            $where .= ' ' . 'and x.motorcicle_id = ?';
            array_push($binds, $motorcicleId);
        }

        $where .= ' ';

        return DB::select("SELECT * FROM view_gasoline x" . $where . "order by x.id desc", $binds);
    }

}
