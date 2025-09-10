-- SEQUENCE: public.pacientecheckos_id_seq

-- DROP SEQUENCE public.pacientecheckos_id_seq;

CREATE SEQUENCE public.pacientecheckos_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.pacientecheckos_id_seq
    OWNER TO postgres;


-- Table: public.pacientecheckos

-- DROP TABLE public.pacientecheckos;

CREATE TABLE public.pacientecheckos
(
    id integer NOT NULL DEFAULT nextval('pacientecheckos_id_seq'::regclass),
    id_paciente integer NOT NULL,
    fechahora timestamp without time zone NOT NULL,
    tiene_os boolean NOT NULL,
    CONSTRAINT paciente_os_check_pkey PRIMARY KEY (id),
    CONSTRAINT paciente_os_check_id_paciente_fkey FOREIGN KEY (id_paciente)
        REFERENCES public.paciente (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

-- Paso 1: Eliminar la constraint existente
ALTER TABLE pacientecheckos
DROP CONSTRAINT paciente_os_check_id_paciente_fkey;

-- Paso 2: Crear la constraint nuevamente con ON DELETE CASCADE
ALTER TABLE pacientecheckos
ADD CONSTRAINT paciente_os_check_id_paciente_fkey
FOREIGN KEY (id_paciente)
REFERENCES paciente(id)
ON DELETE CASCADE;

---script para corregir los registros que tenian en la tabla carnet SIN OBRA SOCIAL --
--insertandolos en la tabla pacientecheckos
--insert en la tabla pacientecheckos los registros de la tabla carnet_os cuyo id sea 36 (SI OBRA SOCIAL)
INSERT INTO pacientecheckos (id_paciente, fechahora, tiene_os)
SELECT DISTINCT ON (c.id_paciente)
       c.id_paciente,
       (a.fecha::text || ' ' || a.hora::text)::timestamp AS fechahora,
       false
FROM carnet_os c
JOIN auditoria a ON c.id = a.registro
WHERE a.tabla = 'CarnetOs'
  AND a.accion = 'CREACIÓN'
  AND c.id_obrasocial = 36
ORDER BY c.id_paciente, a.id;
--Luego elimino de la tabla carnet_os todos esos registros que dicen sin OBRA SOCIAL.
DELETE FROM carnet_os WHERE id_obrasocial=36
-- Una vez que hice la eliminacion inserto en la tabla pacientecheckos los resigistros que tienen obra social con
--la siguiente sentencia.
INSERT INTO pacientecheckos (id_paciente, fechahora, tiene_os)
SELECT DISTINCT ON (c.id_paciente)
       c.id_paciente,
       (a.fecha::text || ' ' || a.hora::text)::timestamp AS fechahora,
       true
FROM carnet_os c
JOIN auditoria a ON c.id = a.registro
WHERE a.tabla = 'CarnetOs'
  AND a.accion = 'CREACIÓN'
ORDER BY c.id_paciente, a.id;
