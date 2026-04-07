ALTER TABLE usuario
ADD cambioforzadocontrasenia BOOLEAN NOT NULL DEFAULT false;

ALTER TABLE carnet_os
MODIFY COLUMN id_paciente INT NOT NULL;

ALTER TABLE carnet_os
ADD CONSTRAINT fk_carnet_os_paciente
FOREIGN KEY (id_paciente) REFERENCES paciente(id)
ON DELETE CASCADE
ON UPDATE CASCADE;
