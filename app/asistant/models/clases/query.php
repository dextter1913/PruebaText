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
    public static function ReadAgentes($creador)
    {
        return "
            SELECT * FROM Agentes
            INNER JOIN Usuarios ON 
            Agentes.usuario = Usuarios.usuario
            WHERE creador = '$creador'
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

    public static function ReadDialogs($user)
    {
        return "call SP_CreateDialogs('$user')";
    }

    //Consultar AccesWebToken
    public static function ReadAwebT($user)
    {
        return "CALL SP_ReadAccesWebToken('$user')";
    }

    //Modificar Dialogs
    public static function UpdateDialogs($idAgente, $name, $user)
    {
        return "UPDATE dialogs set idAgentes = '$idAgente', Asignador = '$user' WHERE name = '$name'";
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

    //TODO LO RELACIONADO CON LOS CONTEOS
    //Mostrando cantidad de chats asignados de cada agente
    public static function ReadConteoChatAsignadosAgentes($user)
    {
        return "CALL SP_ConteoChatAgente('$user')";
    }

    //Mostrando Chat Abiertos
    public static function ReadChatAbiertos($user)
    {
        return "CALL SP_ConteoChatAbiertosAdmin('$user')";
    }

    //Mostrando Agentes con su cantidad de Chat Asignados
    public static function ReadChatAsignadosAgentes($user)
    {
        return "SELECT * FROM Agentes WHERE creador = '$user'";
    }

    //Mostrando Chat Asignado a Agentes
    public static function ReadChatAsignados($user)
    {
        return "CALL SP_ConteoChatAsignadosAdmin('$user')";
    }


    //Mostrando Cantidad de chats cerrados
    public static function ReadConteoChatCerrados($user)
    {
        return "CALL SP_ConteoChatCerradosAdmin('$user')";
    }

    //Mostrando cantidad de chats asignados de cada agente
    public static function ReadConteoChatPendientes($user)
    {
        return "CALL SP_ConteoChatAgente('$user')";
    }
    ////////////////////////////////////////////////////


    //TODO LO RELACIONADO CON EL CHAT
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

    //Update para ingresar mensaje antes de cerrar Chat
    public static function ReadMensajeDespedidaChat($user)
    {
        return "CALL SP_ReadMensajeDespedidaCreador('$user')";
    }


    //Mostrando Ultimo Mensaje de Despedida en la tabla
    public static function ReadMensajeDespedida($user)
    {
        return "SELECT * FROM MensajeDespedida WHERE usuario = '$user'";
    }

    //Update para cerrar chat
    public static function UpdateDialogsCerrarChat($id)
    {
        return "UPDATE dialogs SET abierto = FALSE  WHERE id = '$id'";
    }
}
