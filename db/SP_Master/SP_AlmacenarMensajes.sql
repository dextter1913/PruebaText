use whatsapp;
DROP PROCEDURE IF EXISTS SP_AlmacenarMensajes;

delimiter // 
CREATE PROCEDURE SP_AlmacenarMensajes (in v_id VARCHAR(255), in v_body TEXT, in v_fromMe BOOLEAN, in v_self INT, in v_isForwarded INT, in v_author VARCHAR(100), in v_time INT, in v_chatId VARCHAR(100), in v_messageNumber INT, in v_type VARCHAR(55), in v_senderName VARCHAR(255), in v_quotedMsgBody TEXT, in v_quotedMsgId TEXT, in v_quotedMsgType TEXT, in v_metadata TEXT, in v_ack TEXT, in v_chatName VARCHAR(255), in v_sender VARCHAR(255)) 
BEGIN

INSERT INTO messages(id, body, fromMe, self, isForwarded, author, time, chatId, messageNumber, type, senderName, quotedMsgBody, quotedMsgId, quotedMsgType, metadata, ack, chatName, sender) VALUES( v_id, v_body, v_fromMe, v_self, v_isForwarded, v_author, v_time, v_chatId, v_messageNumber, v_type, v_senderName, v_quotedMsgBody, v_quotedMsgId, v_quotedMsgType, v_metadata, v_ack, v_chatName, v_sender);
END // 
