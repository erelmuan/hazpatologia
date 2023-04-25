
-- SEQUENCE: public.configuracion_id_seq

-- DROP SEQUENCE public.configuracion_id_seq;

CREATE SEQUENCE public.configuracion_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.configuracion_id_seq
    OWNER TO postgres;

-- Table: public.configuracion

-- DROP TABLE public.configuracion;

CREATE TABLE public.configuracion
(
    id integer NOT NULL DEFAULT nextval('configuracion_id_seq'::regclass),
    id_tema integer NOT NULL DEFAULT 1,
    notificacion boolean NOT NULL DEFAULT false,
    id_menu integer NOT NULL DEFAULT 1,
    CONSTRAINT configuracion_pkey PRIMARY KEY (id),
    CONSTRAINT configuracion_id_menu_fkey FOREIGN KEY (id_menu)
        REFERENCES public.menu (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT configuracion_id_tema_fkey FOREIGN KEY (id_tema)
        REFERENCES public.tema (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)

TABLESPACE pg_default;

ALTER TABLE public.configuracion
    OWNER to postgres;
