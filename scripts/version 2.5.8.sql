--antes hay que eliminar la vista, pero antes hacer el resguardo para despues volverla a crear.
ALTER TABLE public.procedencia
    ALTER COLUMN nombre TYPE character varying(30) COLLATE pg_catalog."default";
