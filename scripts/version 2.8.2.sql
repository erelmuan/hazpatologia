
tube que agregar id_rol en modulo
tengo que quitar el unique en modulo y poner otro tipo de unique que sea el nombre
y el id_tipo_acceso

ALTER TABLE public.usuario
ADD COLUMN id_rol integer;

ALTER TABLE public.usuario
ADD CONSTRAINT usuario_id_rol_fkey FOREIGN KEY (id_rol)
REFERENCES public.rol (id) MATCH SIMPLE
ON UPDATE NO ACTION
ON DELETE NO ACTION;

DROP TABLE IF EXISTS public.usuariorol;

-- DROP COLUMN si existe delete, update, create, y view de la tabla public.accion
ALTER TABLE public.accion
      DROP COLUMN IF EXISTS index,
  ;
-- SEQUENCE: public.tipo_acceso_id_seq

-- DROP SEQUENCE public.tipo_acceso_id_seq;

CREATE SEQUENCE public.tipo_acceso_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.tipo_acceso_id_seq
    OWNER TO postgres;


-- Table: public.tipo_acceso

-- DROP TABLE public.tipo_acceso;

CREATE TABLE public.tipo_acceso
(
    id integer NOT NULL DEFAULT nextval('tipo_acceso_id_seq'::regclass),
    nombre character varying COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT tipo_acceso_pkey PRIMARY KEY (id),
    CONSTRAINT tipo_acceso_nombre_nombre1_key UNIQUE (nombre)
        INCLUDE(nombre)
)

TABLESPACE pg_default;

ALTER TABLE public.tipo_acceso
    OWNER to postgres;
