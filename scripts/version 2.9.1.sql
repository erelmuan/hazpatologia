-- SEQUENCE: public.adjuntosolicitud_id_seq

-- DROP SEQUENCE public.adjuntosolicitud_id_seq;

CREATE SEQUENCE public.adjuntosolicitud_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.adjuntosolicitud_id_seq
    OWNER TO postgres;

-- Table: public.adjuntosolicitud

-- DROP TABLE public.adjuntosolicitud;


CREATE TABLE public.adjuntosolicitud
(
    id integer NOT NULL DEFAULT nextval('adjuntosolicitud_id_seq'::regclass),
    nombre_archivo character varying COLLATE pg_catalog."default" NOT NULL,
    nombre_asignado character varying COLLATE pg_catalog."default" NOT NULL,
    baja_logica boolean NOT NULL,
    id_solicitud integer NOT NULL,
    observacion character varying COLLATE pg_catalog."default",
    CONSTRAINT adjuntos_solicitud_pkey PRIMARY KEY (id),
    CONSTRAINT adjuntos_solicitud_nombre_archivo_id_solicitud_key UNIQUE (nombre_archivo, id_solicitud)
)
INSERT INTO estados (id, descripcion, explicacion)
VALUES
    (3, 'DERIVADO', 'El estado "DERIVADO" indica que el estudio ha sido enviado a un laboratorio externo.'),
    (4, 'NO REALIZADO', 'El estado "NO REALIZADO" indica que el estudio no fue procesado en el servicio.'),
    (7, 'DERIVADO LISTO', 'El estado "DERIVADO LISTO" indica que el estudio que fue derivado ya se encuentra listo.');
    (8, 'DERIVADO NO REALIZADO', 'El estado "DERIVADO NO REALIZADO" indica que el estudio que fue derivado ya se encuentra listo.');



    -- SEQUENCE: public.materialsolicitud_solicitud_id_seq

    -- DROP SEQUENCE public.materialsolicitud_solicitud_id_seq;

    CREATE SEQUENCE public.materialsolicitud_solicitud_id_seq
        INCREMENT 1
        START 1
        MINVALUE 1
        MAXVALUE 2147483647
        CACHE 1;

    ALTER SEQUENCE public.materialsolicitud_solicitud_id_seq
        OWNER TO postgres;

        -- Table: public.materialsolicitud_solicitud

        -- DROP TABLE public.materialsolicitud_solicitud;

        CREATE TABLE public.materialsolicitud_solicitud
        (
            id_solicitud integer NOT NULL,
            id_materialsolicitud integer NOT NULL,
            id integer NOT NULL DEFAULT nextval('materialsolicitud_solicitud_id_seq'::regclass),
            id_estudio integer NOT NULL,
            CONSTRAINT materialsolicitud_solicitud_pkey PRIMARY KEY (id),
            CONSTRAINT material_solicitud_id_materialsolicitud_fkey FOREIGN KEY (id_materialsolicitud)
                REFERENCES public.materialsolicitud (id) MATCH SIMPLE
                ON UPDATE NO ACTION
                ON DELETE NO ACTION,
            CONSTRAINT materialsolicitud_solicitud_id_estudio_fkey FOREIGN KEY (id_estudio)
                REFERENCES public.estudio (id) MATCH SIMPLE
                ON UPDATE NO ACTION
                ON DELETE NO ACTION
                NOT VALID
        )

        TABLESPACE pg_default;

        ALTER TABLE public.materialsolicitud_solicitud
            OWNER to postgres;

        -- Trigger: chk_insert_materialsolicitud

        -- DROP TRIGGER chk_insert_materialsolicitud ON public.materialsolicitud_solicitud;

        CREATE TRIGGER chk_insert_materialsolicitud
            BEFORE INSERT OR UPDATE
            ON public.materialsolicitud_solicitud
            FOR EACH ROW
            EXECUTE PROCEDURE public.trg_validate_materialsolicitud();

--------------------------------------------------------------------------------


    -- 1) Reemplazamos la función de validación
    CREATE OR REPLACE FUNCTION trg_validate_materialsolicitud()
    RETURNS TRIGGER AS $$
    BEGIN
      -- NEW.id_solicitud debe existir al menos en una de las dos tablas hijas
      IF NOT EXISTS (SELECT 1 FROM solicitudpap     WHERE id = NEW.id_solicitud)
         AND NOT EXISTS (SELECT 1 FROM solicitudbiopsia WHERE id = NEW.id_solicitud) THEN
        RAISE EXCEPTION 'materialsolicitud_solicitud inválido: id_solicitud % no existe en solicitudpap ni en solicitudbiopsia', NEW.id_solicitud;
      END IF;
      RETURN NEW;
    END;
    $$ LANGUAGE plpgsql;

    -- 2) Volvemos a crear el trigger sobre la tabla correcta
    DROP TRIGGER IF EXISTS chk_insert_materialsolicitud
      ON materialsolicitud_solicitud;

    CREATE TRIGGER chk_insert_materialsolicitud
      BEFORE INSERT OR UPDATE ON materialsolicitud_solicitud
      FOR EACH ROW
      EXECUTE FUNCTION trg_validate_materialsolicitud();

      -- 1) Creamos o reemplazamos la función de validación para adjuntosolicitud
      CREATE OR REPLACE FUNCTION trg_validate_adjuntosolicitud()
      RETURNS TRIGGER AS $$
      BEGIN
        -- Comprobamos que NEW.id_solicitud esté en solicitudpap o en solicitudbiopsia
        IF NOT EXISTS (SELECT 1 FROM solicitudpap     WHERE id = NEW.id_solicitud)
           AND NOT EXISTS (SELECT 1 FROM solicitudbiopsia WHERE id = NEW.id_solicitud) THEN
          RAISE EXCEPTION 'adjuntosolicitud inválido: id_solicitud % no existe en solicitudpap ni en solicitudbiopsia', NEW.id_solicitud;
        END IF;
        RETURN NEW;
      END;
      $$ LANGUAGE plpgsql;

      -- 2) Re-creamos el trigger sobre la tabla adjuntosolicitud
      DROP TRIGGER IF EXISTS chk_insert_adjuntosolicitud
        ON adjuntosolicitud;

      CREATE TRIGGER chk_insert_adjuntosolicitud
        BEFORE INSERT OR UPDATE ON adjuntosolicitud
        FOR EACH ROW
        EXECUTE FUNCTION trg_validate_adjuntosolicitud();





        ------------------------
        CREATE OR REPLACE FUNCTION trg_prevent_delete_solicitudbiopsia()
RETURNS TRIGGER AS $$
BEGIN
  IF EXISTS (SELECT 1 FROM adjuntosolicitud WHERE id_solicitud = OLD.id) THEN
    RAISE EXCEPTION 'No se puede eliminar solicitudbiopsia %: tiene adjuntos asociados', OLD.id;
  END IF;
  RETURN OLD;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS chk_delete_solicitudbiopsia ON solicitudbiopsia;

CREATE TRIGGER chk_delete_solicitudbiopsia
  BEFORE DELETE ON solicitudbiopsia
  FOR EACH ROW
  EXECUTE FUNCTION trg_prevent_delete_solicitudbiopsia();
----------------------------------------
CREATE OR REPLACE FUNCTION trg_prevent_delete_solicitudpap()
RETURNS TRIGGER AS $$
BEGIN
  IF EXISTS (SELECT 1 FROM adjuntosolicitud WHERE id_solicitud = OLD.id) THEN
    RAISE EXCEPTION 'No se puede eliminar solicitudpap %: tiene adjuntos asociados', OLD.id;
  END IF;
  RETURN OLD;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS chk_delete_solicitudpap ON solicitudpap;

CREATE TRIGGER chk_delete_solicitudpap
  BEFORE DELETE ON solicitudpap
  FOR EACH ROW
  EXECUTE FUNCTION trg_prevent_delete_solicitudpap();
