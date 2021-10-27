use whatsapp;
DROP PROCEDURE IF EXISTS SP_MostrarConversacionAgente;

delimiter //
CREATE PROCEDURE SP_MostrarConversacionAgente(in v_id TEXT)
BEGIN

DECLARE v_idDialogs TEXT;
SET v_idDialogs = (SELECT id FROM dialogs WHERE idAgentes = v_id);

SELECT * FROM messages WHERE chatId = v_idDialogs ORDER BY messageNumber DESC;


END //
