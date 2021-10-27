use whatsapp;
DROP PROCEDURE IF EXISTS SP_ConteoChatAsignados;

delimiter $$
CREATE PROCEDURE SP_ConteoChatAsignados()
	BEGIN
		DECLARE v_conteo INT;
		SET v_conteo = (SELECT COUNT(idAgentes) FROM dialogs);
		SELECT v_conteo;
	END $$
delimiter ;
