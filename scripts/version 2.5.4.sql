--Agrego una columna en la tabla usuario
ALTER TABLE usuario ADD COLUMN id_localidad integer;
ALTER TABLE usuario ADD CONSTRAINT usuario_id_localidad_fkey FOREIGN KEY (id_localidad) REFERENCES localidad(id);

--Agrego una columna en la tabla usuario
ALTER TABLE usuario ADD COLUMN id_provincia integer;
ALTER TABLE usuario ADD CONSTRAINT usuario_id_provincia_fkey FOREIGN KEY (id_provincia) REFERENCES provincia(id);
