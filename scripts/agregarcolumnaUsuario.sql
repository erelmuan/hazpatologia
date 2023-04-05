--- se agrega la colummna token a la tabla usuario para permitir la autenticacion mediante una consulta rest---

ALTER TABLE usuario ADD COLUMN token character varying;
