use whatsapp;
DROP Procedure IF EXISTS SP_ReadAccesWebToken;

DELIMITER //
CREATE Procedure SP_ReadAccesWebToken(IN v_user VARCHAR(55))
BEGIN

DECLARE v_creador VARCHAR(255);
SET v_creador = (SELECT creador FROM Agentes WHERE usuario = v_user);

SELECT * FROM TokenChatApi WHERE user = v_creador ORDER BY idToken DESC Limit 1;
END //