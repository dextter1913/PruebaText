use whatsapp;
DROP PROCEDURE IF EXISTS SP_CreateDialogs;
DELIMITER //

CREATE PROCEDURE SP_CreateDialogs(IN v_user VARCHAR(255))
BEGIN

DECLARE v_id INT;
SET v_id = (SELECT id FROM Agentes WHERE usuario = v_user);

SELECT * FROM dialogs  WHERE idAgentes = v_id OR Asignador = v_user;

END //
