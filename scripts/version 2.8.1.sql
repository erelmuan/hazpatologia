-- SEQUENCE: public.configuracion_anio_usuario_id_seq

-- DROP SEQUENCE public.configuracion_anio_usuario_id_seq;

CREATE SEQUENCE public.configuracion_anio_usuario_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.configuracion_anio_usuario_id_seq
    OWNER TO postgres;


-- Table: public.configuracion_anios_usuario

-- DROP TABLE public.configuracion_anios_usuario;

CREATE TABLE public.configuracion_anios_usuario
(
    id integer NOT NULL DEFAULT nextval('configuracion_anio_usuario_id_seq'::regclass),
    id_usuario integer NOT NULL,
    id_anio_protocolo integer NOT NULL,
    id_estudio integer NOT NULL,
    CONSTRAINT configuracion_anio_usuario_pkey PRIMARY KEY (id),
    CONSTRAINT "configuracion_anio_usuario_id_usuario _fkey" FOREIGN KEY (id_usuario)
        REFERENCES public.usuario (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT configuracion_anios_usuario_id_anio_protocolo_fkey FOREIGN KEY (id_anio_protocolo)
        REFERENCES public.anio_protocolo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT configuracion_anios_usuario_id_estudio_fkey FOREIGN KEY (id_estudio)
        REFERENCES public.estudio (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)

TABLESPACE pg_default;

ALTER TABLE public.configuracion_anios_usuario
    OWNER to postgres;
