-- Table: public.vph_escaneado

-- DROP TABLE public.vph_escaneado;

CREATE TABLE public.vph_escaneado
(
    id integer NOT NULL DEFAULT nextval('vph_escaneado_id_seq'::regclass),
    documento character varying COLLATE pg_catalog."default",
    id_pap integer,
    observacion text COLLATE pg_catalog."default",
    nombre_archivo character varying COLLATE pg_catalog."default",
    baja_logica boolean NOT NULL DEFAULT false,
    CONSTRAINT primary_key_vph_escaneada PRIMARY KEY (id),
    CONSTRAINT unique_documento_vph UNIQUE (documento),
    CONSTRAINT unique_id_pap_vph UNIQUE (id_pap),
    CONSTRAINT "foreign:key_vph_pap" FOREIGN KEY (id_pap)
        REFERENCES public.pap (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE public.vph_escaneado
    OWNER to postgres;
