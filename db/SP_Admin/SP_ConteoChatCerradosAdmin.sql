USE whatsapp;

DROP PROCEDURE IF EXISTS SP_ConteoChatCerradosAdmin;
DELIMITER //
CREATE PROCEDURE SP_ConteoChatCerradosAdmin(in v_usuario VARCHAR(255))
BEGIN

DECLARE v_id INT;
DECLARE v_conteo INT;
SET v_id = (SELECT id FROM Agentes WHERE usuario = v_usuario);
SET v_conteo = (SELECT count(abierto) FROM dialogs WHERE idAgentes = v_id AND abierto = FALSE);
select  v_conteo;
END //

DELIMITER;

