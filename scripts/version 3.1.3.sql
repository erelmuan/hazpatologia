CREATE TYPE tipo_procedencia AS ENUM (
    'Hospitalaria',
    'Centro de salud',
    'Extra hospitalaria'
);
ALTER TABLE procedencia
ADD COLUMN tipoprocedencia tipo_procedencia_enum
NOT NULL
DEFAULT 'Hospitalaria';

-- SEQUENCE: public.informecomplementario_id_seq

-- DROP SEQUENCE public.informecomplementario_id_seq;

CREATE SEQUENCE public.informe_complementario_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.informe_complementario_id_seq
    OWNER TO postgres;

    -- Table: public.informe_complementario

    -- DROP TABLE public.informe_complementario;

    CREATE TABLE public.informe_complementario
    (
        id integer NOT NULL DEFAULT nextval('informe_complementario_id_seq'::regclass),
        id_biopsia integer NOT NULL,
        descripcion character varying COLLATE pg_catalog."default" NOT NULL,
        id_estado integer NOT NULL,
        id_usuario integer,
        fecha_listo timestamp with time zone,
        CONSTRAINT informe_complementario_pkey PRIMARY KEY (id),
        CONSTRAINT informe_complementario_id_biopsia_key UNIQUE (id_biopsia),
        CONSTRAINT informe_complementario_id_biopsia_fkey FOREIGN KEY (id_biopsia)
            REFERENCES public.biopsia (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
            NOT VALID,
        CONSTRAINT informe_complementario_id_estado_fkey FOREIGN KEY (id_estado)
            REFERENCES public.estado (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
            NOT VALID,
        CONSTRAINT informe_complementario_id_usuario_fkey FOREIGN KEY (id_usuario)
            REFERENCES public.usuario (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
            NOT VALID
    )

    TABLESPACE pg_default;

    ALTER TABLE public.informe_complementario
        OWNER to postgres;
