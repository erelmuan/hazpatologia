-- SEQUENCE: public.tema_id_seq

-- DROP SEQUENCE public.tema_id_seq;

CREATE SEQUENCE public.tema_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.tema_id_seq
    OWNER TO postgres;

-- Table: public.tema

-- DROP TABLE public.tema;

CREATE TABLE public.tema
(
    id integer NOT NULL DEFAULT nextval('tema_id_seq'::regclass),
    descripcion character varying COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT tema_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE public.tema
    OWNER to postgres;
