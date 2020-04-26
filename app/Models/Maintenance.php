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

        if ($motorcicleId) {
            $where .= ' ' . 'and x.motorcicle_id = ?';
            array_push($binds, $motorcicleId);
        }

        if ($partId) {
            $where .= ' ' . 'and x.part_id = ?';
            array_push($binds, (int) $partId);
        }

        $where .= ' ';

        return DB::select(
            "SELECT
                x.id,
                x.date,
                DATE_FORMAT(x.date, '%d/%m/%Y') as date_formart,
                x.motorcicle_id,
                x.board,
                x.part_id,
                x.name,
                x.km_last,
                x.km,
                x.km_per_run,
                x.price,
                x.created_at,
                x.updated_at
            from
                (
                SELECT
                    IF (@motoId <> m.motorcicle_id or @partId <> m.part_id, @kmlast := 0, NULL),
                    m.id,
                    m.date,
                    m.motorcicle_id,
                    mc.board ,
                    m.part_id,
                    p.name,
                    @kmlast as km_last,
                    m.km,
                    CASE
                        when @kmlast = 0
                            then 0
                        else
                            (m.km - @kmlast)
                    end as km_per_run,
                    m.mechanic,
                    m.price,
                    m.created_at,
                    m.updated_at,
                    @kmlast := m.km,
                    @motoId := m.motorcicle_id,
                    @partId := m.part_id
                from
                    maintenance m
                join motorcicles mc on
                    (mc.id = m.motorcicle_id)
                join parts p on
                    (p.id = m.part_id)
                order by m.motorcicle_id, m.part_id, m.date, m.id
            ) x " . $where . "ORDER by x.motorcicle_id, x.part_id, x.date desc, x.id desc", $binds);
    }

}
