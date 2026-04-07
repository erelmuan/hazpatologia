---
TENGO QUE VER TODOS LOS CAMPOS QUE AGREGUE POR QUERY PORQUE NO TENIA
EL ABM EN LA Vista

delete from carnet_os co
where not exists (
select 1
	from solicitud s
	where s.id_paciente=co.id_paciente
)

DELETE 73 paciente que tenian obra social y no tenian solicitud

Query returned successfully in 116 msec.


---
delete from paciente p
where not exists( select 1
				from solicitud s
				 where s.id_paciente=p.id
				)
        DELETE 113802

Query returned successfully in 2 min 50 secs.
-- Table: public.genero

-- DROP TABLE public.genero;

----
-- SEQUENCE: public.genero_id_seq

-- DROP SEQUENCE public.genero_id_seq;

CREATE SEQUENCE public.genero_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.genero_id_seq
    OWNER TO postgres;

		CREATE TABLE public.genero
		(
		    id integer NOT NULL DEFAULT nextval('genero_id_seq'::regclass),
		    nombre character varying COLLATE pg_catalog."default" NOT NULL,
		    CONSTRAINT genero_pkey PRIMARY KEY (id)
		)

		TABLESPACE pg_default;

		ALTER TABLE public.genero
		    OWNER to postgres;


		-----
		ALTER TABLE paciente
		ADD COLUMN id_genero INTEGER;

		ALTER TABLE paciente
ADD CONSTRAINT paciente_id_genero_fkey
FOREIGN KEY (id_genero)
REFERENCES genero(id);
-- SEQUENCE: public.tipotel_id_seq

-- DROP SEQUENCE public.tipotel_id_seq;

CREATE SEQUENCE public.tipotel_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.tipotel_id_seq
    OWNER TO postgres;
    -- Table: public.tipotel

    -- DROP TABLE public.tipotel;

CREATE TABLE public.tipotel
(
    id integer NOT NULL DEFAULT nextval('tipotel_id_seq'::regclass),
    descripcion character varying COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT primary_key_id PRIMARY KEY (id),
    CONSTRAINT tipotel_descripcion_key UNIQUE (descripcion)
)

TABLESPACE pg_default;

ALTER TABLE public.tipotel
    OWNER to postgres;


-- SEQUENCE: public.tipodom_id_seq

-- DROP SEQUENCE public.tipodom_id_seq;

CREATE SEQUENCE public.tipodom_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.tipodom_id_seq
    OWNER TO postgres;


  -- Table: public.tipodom

  -- DROP TABLE public.tipodom;

  CREATE TABLE public.tipodom
  (
      id integer NOT NULL DEFAULT nextval('tipodom_id_seq'::regclass),
      descripcion character varying COLLATE pg_catalog."default" NOT NULL,
      CONSTRAINT primary_key_tipodom PRIMARY KEY (id),
      CONSTRAINT tipodom_descripcion_key UNIQUE (descripcion)
  )

  TABLESPACE pg_default;

  ALTER TABLE public.tipodom
      OWNER to postgres;
-- SEQUENCE: public.barrio_id_seq

-- DROP SEQUENCE public.barrio_id_seq;

CREATE SEQUENCE public.barrio_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.barrio_id_seq
    OWNER TO postgres;

    -- Table: public.barrio

    -- DROP TABLE public.barrio;

    CREATE TABLE public.barrio
    (
        id integer NOT NULL DEFAULT nextval('barrio_id_seq'::regclass),
        nombre character varying COLLATE pg_catalog."default" NOT NULL,
        id_localidad integer NOT NULL,
        CONSTRAINT primary_key_barrio PRIMARY KEY (id),
        CONSTRAINT barrio_nombre_id_localidad_key UNIQUE (nombre, id_localidad),
        CONSTRAINT foreign_key_localidad FOREIGN KEY (id_localidad)
            REFERENCES public.localidad (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
    )

    TABLESPACE pg_default;

ALTER TABLE public.barrio
    OWNER to postgres;


-- SEQUENCE: public.correo_id_seq

-- DROP SEQUENCE public.correo_id_seq;

CREATE SEQUENCE public.correo_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.correo_id_seq
    OWNER TO postgres;

    -- Table: public.correo

    -- DROP TABLE public.correo;

  CREATE TABLE public.correo
  (
      id integer NOT NULL DEFAULT nextval('correo_id_seq'::regclass),
      direccion character varying COLLATE pg_catalog."default",
      id_paciente integer,
      fechabaja date,
      CONSTRAINT primary_key_correo PRIMARY KEY (id),
      CONSTRAINT unique_direccion UNIQUE (direccion),
      CONSTRAINT foreign_key_paciente FOREIGN KEY (id_paciente)
          REFERENCES public.paciente (id) MATCH SIMPLE
          ON UPDATE NO ACTION
          ON DELETE NO ACTION
  )

  TABLESPACE pg_default;

  ALTER TABLE public.correo
      OWNER to postgres;

  -- SEQUENCE: public.domicilio_id_seq

  -- DROP SEQUENCE public.domicilio_id_seq;

  CREATE SEQUENCE public.domicilio_id_seq
      INCREMENT 1
      START 1
      MINVALUE 1
      MAXVALUE 9223372036854775807
      CACHE 1;

  ALTER SEQUENCE public.domicilio_id_seq
      OWNER TO postgres;

      -- Table: public.domicilio

      -- DROP TABLE public.domicilio;

      -- Table: public.domicilio

      -- DROP TABLE public.domicilio;

      CREATE TABLE public.domicilio
      (
          id integer NOT NULL DEFAULT nextval('domicilio_id_seq'::regclass),
          calle character varying COLLATE pg_catalog."default" NOT NULL,
          id_barrio integer,
          id_paciente integer NOT NULL,
          id_provincia integer NOT NULL DEFAULT 22,
          id_localidad integer NOT NULL,
          id_tipodom integer DEFAULT 1,
          fechabaja date,
          principal boolean,
          numero character varying COLLATE pg_catalog."default",
          piso character varying COLLATE pg_catalog."default",
          departamento character varying COLLATE pg_catalog."default",
          codigopostal character varying COLLATE pg_catalog."default",
          CONSTRAINT primary_key_domicilio PRIMARY KEY (id),
          CONSTRAINT foreign_key_barrio FOREIGN KEY (id_barrio)
              REFERENCES public.barrio (id) MATCH SIMPLE
              ON UPDATE NO ACTION
              ON DELETE NO ACTION,
          CONSTRAINT foreign_key_localidad FOREIGN KEY (id_localidad)
              REFERENCES public.localidad (id) MATCH SIMPLE
              ON UPDATE NO ACTION
              ON DELETE NO ACTION,
          CONSTRAINT foreign_key_paciente FOREIGN KEY (id_paciente)
              REFERENCES public.paciente (id) MATCH SIMPLE
              ON UPDATE NO ACTION
              ON DELETE NO ACTION,
          CONSTRAINT foreign_key_tipodom FOREIGN KEY (id_tipodom)
              REFERENCES public.domicilio (id) MATCH SIMPLE
              ON UPDATE NO ACTION
              ON DELETE NO ACTION
              NOT VALID,
          CONSTRAINT foreing_key_provincia FOREIGN KEY (id_provincia)
              REFERENCES public.provincia (id) MATCH SIMPLE
              ON UPDATE NO ACTION
              ON DELETE NO ACTION
      )

      TABLESPACE pg_default;

      ALTER TABLE public.domicilio
          OWNER to postgres;

TABLESPACE pg_default;

ALTER TABLE public.domicilio
    OWNER to postgres;


-- SEQUENCE: public.telefono_id_seq

-- DROP SEQUENCE public.telefono_id_seq;

CREATE SEQUENCE public.telefono_id_seq
  INCREMENT 1
  START 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  CACHE 1;

ALTER SEQUENCE public.telefono_id_seq
  OWNER TO postgres;

  -- Table: public.telefono

  -- DROP TABLE public.telefono;

  CREATE TABLE public.telefono
  (
      id integer NOT NULL DEFAULT nextval('telefono_id_seq'::regclass),
      numero character varying COLLATE pg_catalog."default" NOT NULL,
      id_paciente integer,
      fechabaja date,
      id_tipotel integer,
      CONSTRAINT primary_key_telefono PRIMARY KEY (id),
      CONSTRAINT foreign_key_paciente FOREIGN KEY (id_paciente)
          REFERENCES public.paciente (id) MATCH SIMPLE
          ON UPDATE NO ACTION
          ON DELETE NO ACTION,
      CONSTRAINT foreign_key_tipotel FOREIGN KEY (id_tipotel)
          REFERENCES public.tipotel (id) MATCH SIMPLE
          ON UPDATE NO ACTION
          ON DELETE NO ACTION
  )

  TABLESPACE pg_default;

  ALTER TABLE public.telefono
      OWNER to postgres;

  ALTER TABLE localidad
  ALTER COLUMN codigopostal TYPE varchar;

  ALTER TABLE carnet_os
  ALTER COLUMN nroafiliado SET NOT NULL,
  ALTER COLUMN id_paciente SET NOT NULL,
  ALTER COLUMN id_obrasocial SET NOT NULL;

  -- SEQUENCE: public.tipocontacto_id_seq

  -- DROP SEQUENCE public.tipocontacto_id_seq;

  CREATE SEQUENCE public.tipocontacto_id_seq
      INCREMENT 1
      START 1
      MINVALUE 1
      MAXVALUE 2147483647
      CACHE 1;

  ALTER SEQUENCE public.tipocontacto_id_seq
      OWNER TO postgres;
  -- Table: public.tipocontacto

  -- DROP TABLE public.tipocontacto;

  CREATE TABLE public.tipocontacto
  (
      id integer NOT NULL DEFAULT nextval('tipocontacto_id_seq'::regclass),
      descripcion character varying COLLATE pg_catalog."default" NOT NULL,
      CONSTRAINT tipocontacto_pkey PRIMARY KEY (id)
  )

  TABLESPACE pg_default;

  ALTER TABLE public.tipocontacto
      OWNER to postgres;

------------------------------
-- SEQUENCE: public.tipouso_id_seq

-- DROP SEQUENCE public.tipouso_id_seq;

CREATE SEQUENCE public.tipouso_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.tipouso_id_seq
    OWNER TO postgres;

    -- Table: public.tipouso

    -- DROP TABLE public.tipouso;

    CREATE TABLE public.tipouso
    (
        id integer NOT NULL DEFAULT nextval('tipouso_id_seq'::regclass),
        descripcion character varying COLLATE pg_catalog."default" NOT NULL,
        CONSTRAINT tipouso_pkey PRIMARY KEY (id)
    )

    TABLESPACE pg_default;

    ALTER TABLE public.tipouso
        OWNER to postgres;

    ----


  -- SEQUENCE: public.contacto_id_seq

-- DROP SEQUENCE public.contacto_id_seq;

CREATE SEQUENCE public.contacto_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.contacto_id_seq
    OWNER TO postgres;

    -- Table: public.contacto

    -- DROP TABLE public.contacto;

    CREATE TABLE public.contacto
    (
        id integer NOT NULL DEFAULT nextval('contacto_id_seq'::regclass),
        id_tipocontacto integer NOT NULL,
        valor character varying COLLATE pg_catalog."default" NOT NULL,
        id_tipouso integer NOT NULL,
        fechabaja date,
        id_paciente integer NOT NULL,
        CONSTRAINT contacto_pkey PRIMARY KEY (id),
        CONSTRAINT contacto_id_paciente_fkey FOREIGN KEY (id_paciente)
            REFERENCES public.paciente (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
            NOT VALID,
        CONSTRAINT contacto_id_tipocontacto_fkey FOREIGN KEY (id_tipocontacto)
            REFERENCES public.tipocontacto (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
            NOT VALID,
        CONSTRAINT contacto_id_tipouso_fkey FOREIGN KEY (id_tipouso)
            REFERENCES public.tipouso (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
            NOT VALID
    )

    TABLESPACE pg_default;

    ALTER TABLE public.contacto
        OWNER to postgres;
---------------------------------
INSERT INTO tipocontacto (id, nombre)
VALUES
(1, 'TELÉFONO'),
(2, 'EMAIL');

------
INSERT INTO tipouso (id, nombre)
VALUES
(1, 'PERSONAL'),
(2, 'LABORAL'),
(3, 'FAMILIAR');

-- Insertar los telefonos ----
  INSERT INTO contacto (id_paciente, id_tipocontacto, valor,id_tipouso)
  SELECT id, 1, telefono,1
  FROM paciente
  WHERE telefono IS NOT NULL AND  TRIM(telefono) <> ''


  INSERT 0 5950

  Query returned successfully in 275 msec.
---- Insertar los contactos ----
---insertar domicilios- ----
INSERT INTO domicilio (id_paciente, calle, id_provincia, id_localidad, id_tipodom, codigopostal)
SELECT
    p.id,
    p.direccion,
    p.id_provincia,
    p.id_localidad,
    1,
    l.codigopostal
FROM paciente p
JOIN localidad l ON l.id = p.id_localidad
WHERE p.direccion IS NOT NULL
  AND TRIM(p.direccion) <> ''
  AND UPPER(TRIM(p.direccion)) <> 'DESCONOCIDO'
  AND EXISTS (
      SELECT 1
      FROM solicitud s
      WHERE s.id_paciente = p.id
  );
  INSERT 0 7950

  Query returned successfully in 475 msec.
