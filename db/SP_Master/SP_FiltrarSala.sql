USE whatsapp;
DROP PROCEDURE IF EXISTS SP_FiltrarSala;

DELIMITER //
CREATE PROCEDURE SP_FiltrarSala(IN v_datos VARCHAR(255), IN v_id VARCHAR(255))
BEGIN

SELECT * FROM dialogs WHERE (id LIKE concat(v_datos,'%') OR name LIKE concat(v_datos,'%')) AND idAgentes = v_id;

END //