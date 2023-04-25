
-- SEQUENCE: public.menu_id_seq

-- DROP SEQUENCE public.menu_id_seq;

CREATE SEQUENCE public.menu_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.menu_id_seq
    OWNER TO postgres;
-- Table: public.menu

-- DROP TABLE public.menu;

CREATE TABLE public.menu
(
    id integer NOT NULL DEFAULT nextval('menu_id_seq'::regclass),
    tipo character varying COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT menu_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE public.menu
    OWNER to postgres;
