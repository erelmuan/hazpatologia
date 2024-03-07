-- SEQUENCE: public.registrosesion_id_seq

-- DROP SEQUENCE public.registrosesion_id_seq;

CREATE SEQUENCE public.registrosesion_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.registrosesion_id_seq
    OWNER TO postgres;


-- Table: public.registrosesion

-- DROP TABLE public.registrosesion;

CREATE TABLE public.registrosesion
(
    id integer NOT NULL DEFAULT nextval('registrosesion_id_seq'::regclass),
    id_usuario integer NOT NULL,
    inicio_sesion timestamp without time zone NOT NULL,
    ip character varying COLLATE pg_catalog."default",
    informacion_usuario character varying COLLATE pg_catalog."default",
    cookie character varying COLLATE pg_catalog."default",
    cierre_sesion timestamp without time zone,
    CONSTRAINT registrosesion_pkey PRIMARY KEY (id),
    CONSTRAINT registrosesion_id_usuario_fkey FOREIGN KEY (id_usuario)
        REFERENCES public.usuario (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)

TABLESPACE pg_default;

ALTER TABLE public.registrosesion
    OWNER to postgres;
