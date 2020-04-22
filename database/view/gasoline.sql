create or replace view view_gasoline as select
    g.id,
    g.motorcicle_id,
    m.board,
    g.date,
    lag (g.km, -1) over (PARTITION BY G.motorcicle_id order by g.id desc) km_last,
    g.km,
    g.km - lag(g.km, -1) over (PARTITION BY G.motorcicle_id order by g.id desc) km_per_run,
    (lag(g.km, -1) over (PARTITION BY G.motorcicle_id order by g.id desc) / g.liters) km_per_liters,
    g.liters,
    g.price,
    (g.liters * g.price) as total,
    g.created_at,
    g.updated_at
from
    gasoline g
join motorcicles m on (m.id = g.motorcicle_id);
