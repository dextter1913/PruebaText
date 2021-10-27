DROP PROCEDURE IF EXISTS SP_ConteoChatCerrados;
DELIMITER //

CREATE PROCEDURE SP_ConteoChatCerrados()
BEGIN

DECLARE v_conteo INT;
SET v_conteo = (SELECT COUNT(abierto) FROM dialogs WHERE abierto = 0);

SELECT v_conteo;

END //



