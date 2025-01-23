/*
 ** Modificaciones a BD para usar correctamente Eloquent de Laravel.
*/
ALTER TABLE reniec_familiares   
  ADD COLUMN created_at DATETIME NULL AFTER nombre,
  ADD COLUMN updated_at DATETIME NULL AFTER created_at;
