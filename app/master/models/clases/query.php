<?php

//Aqui van todos los querys de el servicio login
class  query
{
    //Crear usuario
    public static function CreateUsuario(
        $usuario,
        $password,
        $admin,
        $maestro
    ) {
        return "INSERT INTO Usuarios(
            usuario, 
            password, 
            admin, 
            maestro
            ) VALUE(
                '$usuario',
                '$password',
                '$admin',
                '$maestro'
            )";
    }

    //Crear Agente
    public static function CreateAgente(
        $nombre,
        $apellido,
        $documento,
        $telefono,
        $direccion,
        $correo,
        $creador,
        $usuario
    ) {
        return "INSERT INTO Agentes(
                nombre,
                apellido,
                documento,
                telefono,
                direccion,
                correo,
                creador,
                usuario
            ) VALUES(
                '$nombre',
                '$apellido',
                '$documento',
                '$telefono',
                '$direccion',
                '$correo',
                '$creador',
                '$usuario'
            )";
    }

    //Consultar Todos los Agentes y usuarios
    public static function ReadAgentes()
    {
        return "
            SELECT * FROM Agentes
            INNER JOIN Usuarios ON 
            Agentes.usuario = Usuarios.usuario
            ";
    }

    //Cambiar Contraseña del Agente
    public static function UpdatePassword($user, $pass)
    {
        return "UPDATE usuarios SET password = '$pass' WHERE usuario = '$user'";
    }

    //Insertar dialogs
    public static function CreateDialogs($id, $name, $image, $last_time)
    {
        return "INSERT INTO dialogs(id,name,image,last_time) VALUES('$id','$name','$image','$last_time')";
    }

    //Actualizar Imagen Dialogs
    public static function UpdateImageDialogs($id, $image){
        return "UPDATE dialogs SET image = '$image' WHERE id = '$id'";
    }

    //Buscando dialogs
    public static function ReadDialogs()
    {
        return "SELECT * FROM dialogs";
    }

    //Buscando dialogs filtrando por like
    public static function ReadDialogsFiltrando($datos)
    {
        return "SELECT * FROM dialogs WHERE name LIKE '$datos%' OR id LIKE '$datos%'";
    }

    //Crear AccesWebToken
    public static function CreateAwebT($instance, $token, $user)
    {
        return "INSERT INTO TokenChatApi(Instance, Token, user) VALUES('$instance','$token','$user')";
    }

    //Consultar AccesWebToken
    public static function ReadAwebT($user)
    {
        return "SELECT * FROM TokenChatApi WHERE user = '$user' ORDER BY idToken DESC Limit 1";
    }

    //Modificar Dialogs
    public static function UpdateDialogs($idAgente, $id)
    {
        return "UPDATE dialogs set idAgentes = '$idAgente' WHERE id = '$id'";
    }

    //Consultando imagen de Dialogs
    public static function ReadImageDialogs($id)
    {
        return "SELECT image FROM dialogs WHERE id = '$id'";
    }

    //Update para abrir chat
    public static function UpdateDialogsAbrirChat($id)
    {
        return "UPDATE dialogs SET abierto = true WHERE id = '$id'";
    }

    //Update para ingresar mensaje antes de cerrar Chat
    public static function ReadMensajeDespedidaChat($user)
    {
        return "SELECT * FROM MensajeDespedida WHERE usuario = '$user' ORDER BY id DESC LIMIT 1";
    }

    //Update para cerrar chat
    public static function UpdateDialogsCerrarChat($id)
    {
        return "UPDATE dialogs SET abierto = FALSE  WHERE id = '$id'";
    }

    //Mostrando Chat Abiertos
    public static function ReadChatAbiertos()
    {
        return "SELECT abierto FROM dialogs WHERE abierto = TRUE";
    }

    //Mostrando Chat Asignado a Agentes
    public static function ReadChatAsignados()
    {
        return "SELECT count(idAgentes) FROM whatsapp.dialogs";
    }

    //Mostrando Agentes con su cantidad de Chat Asignados
    public static function ReadChatAsignadosAgentes()
    {
        return "SELECT * FROM Agentes";
    }

    //Mostrando cantidad de chats asignados de cada agente
    public static function ReadConteoChatPendientes($user)
    {
        return "CALL SP_ConteoChatAgente('$user')";
    }

    //Mostrando Cantidad de chats cerrados
    public static function ReadConteoChatCerrados()
    {
        return "CALL SP_ConteoChatCerrados";
    }

    //Insertar Mensajes de la api a la base de datos
    public static function CreateAlmacenarMensajes(
        $id,
        $body,
        $fromMe,
        $self,
        $isForwarded,
        $author,
        $time,
        $chatId,
        $messageNumber,
        $type,
        $senderName,
        $quotedMsgBody,
        $quotedMsgId,
        $quotedMsgType,
        $metadata,
        $ack,
        $chatName,
        $sender
    ) {

        return "
        call 
        SP_AlmacenarMensajes     
        (
        '$id',
        '$body',
        '$fromMe',
        '$self',
        '$isForwarded',
        '$author',
        '$time',
        '$chatId',
        '$messageNumber',
        '$type',
        '$senderName',
        '$quotedMsgBody',
        '$quotedMsgId',
        '$quotedMsgType',
        '$metadata',
        '$ack',
        '$chatName',
        '$sender'
        )";
    }

    //Mostrar Mensajes de chat individual
    public static function ReadMensajesChat($id)
    {
        return "call SP_MostrarMensajesChat('$id')";
    }

    //Mostrando conversacion de chat seleccionado
    public static function ReadChatAgente($id)
    {
        return "CALL SP_MostrarConversacionAgente('$id')";
    }

    //Mostrando salas de chat asignadas a un agente o asistente especifico
    public static function ReadDialogsAgente($id)
    {
        return "SELECT * FROM dialogs WHERE idAgentes = '$id'";
    }

    //Insertando Datos a la tabla MensajeDespedida
    public static function CreateMensajeDespedida($cuerpo, $usuario)
    {
        return "INSERT INTO MensajeDespedida(cuerpo, usuario) VALUES('$cuerpo','$usuario')";
    }

    //Mostrando Ultimo Mensaje de Despedida
    public static function ReadMensajeDespedida(){
        return "SELECT * FROM MensajeDespedida";
    }

    //Eliminando mensaje de despedida
    public static function DeleteMensajeDespedida($id){
        return "DELETE FROM mensajedespedida WHERE id = '$id'";
    }

    //Filtrar dialogs por agente
    public static function ReadFiltrarSala($datos, $id){
        return "call SP_FiltrarSala('$datos','$id')";
    }
}
