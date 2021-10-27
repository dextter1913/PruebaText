USE whatsapp;
DROP PROCEDURE IF EXISTS SP_ConteoChatAgente;
delimiter $$
CREATE PROCEDURE SP_ConteoChatAgente(in v_usuario VARCHAR(255))
BEGIN

DECLARE v_id INT;
DECLARE v_cantidadChatAbiertos INT;
DECLARE v_cantidadChatPendiente INT;
SET v_id = (SELECT id FROM Agentes WHERE usuario = v_usuario);
SET v_cantidadChatAbiertos = (SELECT count(abierto) FROM dialogs WHERE idAgentes = v_id AND abierto = 1);
SET v_cantidadChatPendiente = (SELECT count(abierto) FROM dialogs WHERE idAgentes = v_id AND abierto = 0);
SELECT v_cantidadChatAbiertos, v_cantidadChatPendiente;

END$$
delimiter ;