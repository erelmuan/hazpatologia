--- se agrega la colummna token a la tabla usuario para permitir la autenticacion mediante una consulta rest---

ALTER TABLE usuario ADD COLUMN id_configuracion integer;

ALTER TABLE usuario ADD CONSTRAINT usuario_id_configuracion_key UNIQUE (id_configuracion);

ALTER TABLE usuario ADD CONSTRAINT usuario_usuario_key UNIQUE (usuario);
