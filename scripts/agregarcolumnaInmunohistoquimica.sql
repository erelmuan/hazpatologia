---

ALTER TABLE inmunohistoquimica_escaneada ADD COLUMN baja_logica boolean NOT NULL DEFAULT false;

---

ALTER TABLE inmunohistoquimica_escaneada ADD COLUMN nombre_archivo character varying;
