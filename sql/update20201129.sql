/*
 ** Modificaciones a BD para registrar fecha de creación
*/
ALTER TABLE essalud   
  ADD COLUMN created_at DATETIME NULL AFTER sueldo;
ALTER TABLE reniec_hermanos   
  ADD COLUMN created_at DATETIME NULL AFTER nombre;

ALTER TABLE reniec_hermanos   
  ADD COLUMN id BIGINT NOT NULL AUTO_INCREMENT FIRST, 
  ADD PRIMARY KEY (id);

ALTER TABLE reniec_2018   
  ADD COLUMN created_at DATETIME NULL AFTER nombre_pat,
  ADD COLUMN updated_at DATETIME NULL AFTER created_at;

ALTER TABLE correo   
  ADD COLUMN created_at DATETIME NULL AFTER correo,
  ADD COLUMN updated_at DATETIME NULL AFTER created_at;

ALTER TABLE correo   
  DROP COLUMN updated_at;

ALTER TABLE movistar   
  ADD COLUMN created_at DATETIME NULL AFTER numero;

ALTER TABLE movistar_fijo   
  ADD COLUMN created_at DATETIME NULL AFTER numero;

ALTER TABLE claro   
  ADD COLUMN created_at DATETIME NULL AFTER numero;

ALTER TABLE entel   
  ADD COLUMN created_at DATETIME NULL AFTER numero;
