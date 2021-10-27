USE whatsapp;
DROP Procedure IF EXISTS SP_ReadMensajeDespedidaCreador;

DELIMITER // 
CREATE Procedure SP_ReadMensajeDespedidaCreador(IN v_usuario VARCHAR(255))
BEGIN

DECLARE v_asistant VARCHAR(255);
SET v_asistant = (SELECT creador FROM Agentes WHERE usuario = v_usuario);

SELECT * FROM MensajeDespedida WHERE usuario = v_asistant ORDER BY id DESC LIMIT 1;
END //
