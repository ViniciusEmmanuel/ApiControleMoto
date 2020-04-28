-- Querys no lugar da view quando for mysql
SELECT
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
) x ORDER by x.motorcicle_id, x.part_id, x.date desc, x.id desc


SELECT
    x.id,
    x.motorcicle_id,
    x.board,
    x.date,
    DATE_FORMAT(x.date, '%d/%m/%Y') as date_formart,
    x.km_last,
    x.km,
    x.km_per_run,
    x.km_per_liters,
    x.liters,
    x.price,
    x.total,
    x.created_at,
    x.updated_at
FROM
    (
    SELECT
        IF (@motoId <> g.motorcicle_id ,@kmlast := 0, NULL),
        g.id,
        g.motorcicle_id,
        m.board,
        g.date,
        @kmlast as km_last,
        g.km,
        CASE
            when @kmlast = 0
                then 0
            else
                (g.km- @kmlast)
        end as km_per_run,
        CASE
            when @kmlast = 0
                then 0
            else
                ((g.km - @kmlast) / g.liters)
        end as km_per_liters,
        g.liters,
        g.price,
        (g.liters * g.price) as total,
        g.created_at,
        g.updated_at,
        @kmlast := g.km,
        @motoId := g.motorcicle_id
    FROM
        gasoline g
    JOIN motorcicles m ON
        (m.id = g.motorcicle_id),
        (select @kmlast := 0) as w,
        (select @motoId := 0) as ww
) x order by x.id desc
