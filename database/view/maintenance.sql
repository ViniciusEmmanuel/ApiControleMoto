create or replace view view_maintenance as select
	m.id,
	m.motorcicle_id,
	mc.board,
	m.part_id,
	p."name",
	m."date" ,
	TO_CHAR(m.date, 'DD/MM/YYYY') as date_formart,
	lag (m.km,-1) over (PARTITION BY m.motorcicle_id, m.part_id order by m."date" desc, m.id desc) km_last,
	m.km,
	m.km - lag(m.km, -1) over (PARTITION by m.motorcicle_id, m.part_id order by m."date" desc, m.id desc) km_per_run,
	m.mechanic,
	m.price,
	m.description,
	m.created_at,
	m.updated_at
from
	maintenance m
join motorcicles mc on (mc.id  = m.motorcicle_id)
join parts p on (p.id = m.part_id)
where m.deleted = false;
