--Modificacion en la tabla estado
ALTER TABLE estado
DROP COLUMN biopsia,
DROP COLUMN pap,
DROP COLUMN solicitud;
DROP COLUMN ver_informe_estudio;
DROP COLUMN ver_informe_solicitud;

-- Insertar un nuevo registro en la tabla estado
INSERT INTO estado (id, descripcion, explicacion)
VALUES (6, 'ANULADO', 'Son los estudios que han sido dado de baja y ya no podrán ser visualizados en la pantalla de estudios');

--eliminar las validaciones de solicitud, solicitudpap y solicitudbiopsia
ALTER TABLE solicitud
DROP CONSTRAINT anio_protocolo_unico;

ALTER TABLE solicitudbiopsia
DROP CONSTRAINT solicitudbiopsia_protocolo_fechadeingreso_key;

ALTER TABLE solicitudbiopsia
DROP CONSTRAINT solicitudbiopsia_protocolo_fechadeingreso_key;

ALTER TABLE solicitudpap
DROP CONSTRAINT solicitudpap_protocolo_fechadeingreso_key;


--Trigger

--before_insert_solicitudbiopsia_function
BEGIN
    -- Verificar si existe una combinación en la tabla solicitud con id_estado diferente de 6
    IF EXISTS (
        SELECT 1 FROM solicitud s
        WHERE s.protocolo = NEW.protocolo AND s.id_anio_protocolo = NEW.id_anio_protocolo
        AND s.id_estado <> 6
    ) THEN
        -- Si existe, levantar una excepción
        RAISE EXCEPTION 'La combinación de protocolo e id_anio_protocolo ya existe en la tabla solicitud.';
    END IF;

    -- Si no existe, permitir la inserción en la tabla solicitudbiopsia
    RETURN NEW;
END;
--before_insert_solicitudpap_function
BEGIN
    -- Verificar si existe una combinación en la tabla solicitud con id_estado diferente de 6
    IF EXISTS (
        SELECT 1 FROM solicitud s
        WHERE s.protocolo = NEW.protocolo AND s.id_anio_protocolo = NEW.id_anio_protocolo
        AND s.id_estado <> 6
    ) THEN
        -- Si existe, levantar una excepción
        RAISE EXCEPTION 'La combinación de protocolo e id_anio_protocolo ya existe en la tabla solicitud.';
    END IF;

    -- Si no existe, permitir la inserción en la tabla solicitudpap
    RETURN NEW;
END;
