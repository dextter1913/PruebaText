use whatsapp;
DROP PROCEDURE IF EXISTS SP_MostrarMensajesChat;

delimiter //
CREATE PROCEDURE SP_MostrarMensajesChat(in v_id TEXT)
BEGIN
SELECT * FROM messages WHERE id like concat('%',v_id,'%') ORDER BY messageNumber DESC;
END //
delimiter ;