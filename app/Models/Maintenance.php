<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Maintenance extends Model
{

    protected $table = 'maintenance';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $hidden = ['user_id'];

    protected $user_id;

    protected $motorcicle_id;

    protected $part_id;

    protected $date;

    protected $km;

    protected $price;

    protected $mechanic;

    protected $deleted;

    public static function findFormatTable($dateBefore, $dateAfter, $motorcicleId, $partId)
    {
        $where = ' ' . 'where 1 = ?';

        $binds = [1];

        if ($dateAfter && $dateBefore) {
            $where .= ' ' . 'and x.date between date(?) and date(?)';
            array_push($binds, $dateBefore);
            array_push($binds, $dateAfter);
        }

        if ($motorcicleId && gettype((int) $motorcicleId) === 'integer') {
            $where .= ' ' . 'and x.motorcicle_id = ?';
            array_push($binds, $motorcicleId);
        }

        if ($partId && gettype((int) $motorcicleId) === 'integer') {
            $where .= ' ' . 'and x.part_id = ?';
            array_push($binds, (int) $partId);
        }

        $where .= ' ';

        return DB::select("SELECT * FROM view_maintenance x" . $where, $binds);
    }

}
