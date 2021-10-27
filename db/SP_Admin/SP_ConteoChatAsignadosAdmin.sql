use whatsapp;
DROP Procedure IF EXISTS SP_ConteoChatAsignadosAdmin;

DELIMITER //
CREATE Procedure SP_ConteoChatAsignadosAdmin(IN v_user VARCHAR(55))
BEGIN

DECLARE v_id INT;
DECLARE v_conteo INT;
SET v_id = (SELECT id FROM Agentes WHERE usuario = v_user);
SET v_conteo = (SELECT COUNT(idAgentes) FROM dialogs WHERE idAgentes = v_id);

SELECT v_conteo;
END //