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

        return DB::select(
            "select
                x.id,
                x.motorcicle_id,
                x.board,
                x.date,
                x.km_last,
                x.km,
                x.km_per_run,
                x.km_per_liters,
                x.liters,
                x.price,
                x.total,
                x.created_at,
                x.updated_at
            from
                (
                select
                    IF (@motoId <> g.motorcicle_id ,
                    @kmlast := 0,
                    NULL),
                    g.id,
                    g.motorcicle_id,
                    m.board,
                    g.date,
                    @kmlast as km_last,
                    g.km,
                    CASE
                        when @kmlast = 0 then 0
                        else (g.km- @kmlast) end as km_per_run,
                        CASE
                            when @kmlast = 0 then 0
                            else ((g.km - @kmlast) / g.liters) end as km_per_liters,
                            g.liters,
                            g.price,
                            (g.liters * g.price) as total,
                            g.created_at,
                            g.updated_at,
                            @kmlast := g.km,
                            @motoId := g.motorcicle_id
                        from
                            gasoline g
                        join motorcicles m on
                            (m.id = g.motorcicle_id),
                            (select @kmlast := 0) as w,
                            (select @motoId := 0) as ww
                )x " . $where . "order by x.id desc", $binds);
    }

}
