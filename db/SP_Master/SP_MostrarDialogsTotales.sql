DROP PROCEDURE IF EXISTS SP_MostrarDialogsTotales;

DELIMITER //
CREATE PROCEDURE SP_MostrarDialogsTotales()
BEGIN
    SELECT * FROM dialogs;
END //