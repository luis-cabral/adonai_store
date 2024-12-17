DELIMITER ;;
CREATE DEFINER = `root` @`localhost` 
TRIGGER `before_inserting_tabla` BEFORE
INSERT ON `tabla` 
FOR EACH ROW 
BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END ;;

CREATE DEFINER = `root` @`localhost` 
TRIGGER `before_updating_tabla` BEFORE
UPDATE ON `tabla` 
FOR EACH ROW 
BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
        -- 
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END ;;

CREATE DEFINER = `root` @`localhost` 
TRIGGER `before_deleting_tabla` BEFORE
DELETE ON `tabla` 
FOR EACH ROW 
BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_tabla';
    -- 
END ;;

DELIMITER ;
