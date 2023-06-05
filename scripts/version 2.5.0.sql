--Agrego una columna a la tabla estado, llamada explicacion
ALTER TABLE estado ADD COLUMN explicacion character varying;

-- Cabio el nombre de la columna listDetalle por view de la tabla accion---
ALTER TABLE accion RENAME COLUMN listDetalle TO view;
