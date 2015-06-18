-- Agrego dos campos a la tabla CLIENTES
alter table clientes add column estado int default null;
alter table clientes add column fecha_baja datetime default null;
