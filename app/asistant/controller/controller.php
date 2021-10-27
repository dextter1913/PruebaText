<?php

require_once 'app\asistant\models\app_autoload.php';

//Funciones para requerir encabezado, pie de pagina y menu
function higher()
{
    require_once 'app\asistant\views\assets\header.html';
}

function Nav()
{
    $user = $_SESSION['Asistant'];
    //Recibiendo Salas de chat abiertas desde la app de whatsapp
    $AwebT = mysqli_fetch_assoc(crud::Read(query::ReadAwebT($user)));
    $ChatApi = new ChatApi($AwebT['Instance'], $AwebT['Token']);
    $array = $ChatApi->Dialogs();

    //var_dump($array);

    //logica para sacar cantidad de indices y recorrer el array con la cantidad de indices
    foreach ($array as $key => $value) {
        $j = count($value);
        $i = 0;

        while ($i < $j) {
            crud::Create(query::CreateDialogs($value[$i]['id'], $value[$i]['name'], $value[$i]['image'], $value[$i]['last_time']));
            $i++;
        }
    }

    $user = $_SESSION['Asistant'];
    //Salas de chat almacenadas en base de datos
    $consulta = crud::Read(query::ReadDialogs($user));




    require_once 'app\asistant\views\assets\Nav.phtml';
}

function lower()
{
    require_once 'app\asistant\views\assets\footer.html';
}


class controller
{
    //DashBoard
    public static function Inicio()
    {
        if (isset($_SESSION['Asistant'])) {

            //Logica para cerrar chat
            if (isset($_POST['btnCerrarChatConMensaje'])) {
                $user = $_SESSION['Asistant'];


                //Envio de mensaje pregrabado
                $resultados = crud::Read(query::ReadMensajeDespedidaChat($user));
                $mensajeDespedida = mysqli_fetch_assoc($resultados);

                $UrlToken = mysqli_fetch_assoc(crud::Read(query::ReadAwebT($user)));
                $Api = new ChatApi($UrlToken['Instance'], $UrlToken['Token']);
                $Phone = $_POST['chatId'];
                $message = $mensajeDespedida['cuerpo'];
                $Phone = $_POST['btnCerrarChatConMensaje'];
                $Api->SendMenssage($Phone, $message);





                //Cerrando chat abierto
                $id = $_POST['btnCerrarChatConMensaje'] . '@c.us';
                crud::Update(query::UpdateDialogsCerrarChat($id));
            } elseif (isset($_POST['btnCerrarChat'])) {

                $id = $_POST['btnCerrarChat'] . '@c.us';
                crud::Update(query::UpdateDialogsCerrarChat($id));
            }


            higher();
            Nav();
            require_once 'app\asistant\views\modules\dashboard\dashboard.phtml';
            lower();
        } else {
            header('Location:Login');
        }
    }

    //Validacion cuando ingresan al login logeados
    public static function Login()
    {
        header('Location:Inicio');
    }

    //Cerrar Session
    public static function Cerrar()
    {
        session_destroy();
        header('Location:./');
    }


    //TODO LO RELACIONADO CON EL CHAT
    //Sala de chat individual
    public static function SalaChat()
    {
        //Condicion para obligar a tener si o si una sala de chat
        if (!empty($_POST['btnAbrirChat'])) {
            $id = $_POST['btnAbrirChat'];
            $SalaChat = str_replace('@c.us', '', $_POST['btnAbrirChat']);

            //Imagen Guardada
            $resultado = crud::Read(query::ReadImageDialogs($id));
            $image = mysqli_fetch_assoc($resultado);

            //ChatAbiertos
            crud::Update(query::UpdateDialogsAbrirChat($_POST['btnAbrirChat']));


            higher();
            Nav();
            require_once 'app\asistant\views\modules\chat\chat.phtml';
            lower();
        } else {
            header('Location:./');
        }
    }

    //Mostrar Mensajes de chat individual
    public static function MostrarMensajesChat()
    {
        if (!empty($_POST['chatId'])) {
            $user = $_SESSION['Asistant'];
            $id =  $_POST['chatId'];
            $url = mysqli_fetch_assoc(crud::Read(query::ReadAwebT($user)));
            $api = new ChatApi($url['Instance'], $url['Token']);
            $data = $api->messages();

            //cambiando ciclo foreach por ciclo while para hacer insercion a la base de datos usando 
            //la cantidad de indices que tiene el array
            $contador = count($data['messages']);
            $i = 0;
            while ($i < $contador) {
                if ($data['messages'][$i]['author'] === $data['messages'][$i]['chatId']) {
                    $sender[$i] = $data['messages'][$i]['author'];
                } elseif ($data['messages'][$i]['author'] != $data['messages'][$i]['chatId']) {
                    $sender[$i] = $_SESSION['Asistant'];
                }
                crud::Create(query::CreateAlmacenarMensajes(
                    $data['messages'][$i]['id'],
                    $data['messages'][$i]['body'],
                    $data['messages'][$i]['fromMe'],
                    $data['messages'][$i]['self'],
                    $data['messages'][$i]['isForwarded'],
                    $data['messages'][$i]['author'],
                    $data['messages'][$i]['time'],
                    $data['messages'][$i]['chatId'],
                    $data['messages'][$i]['messageNumber'],
                    $data['messages'][$i]['type'],
                    $data['messages'][$i]['senderName'],
                    $data['messages'][$i]['quotedMsgBody'],
                    $data['messages'][$i]['quotedMsgId'],
                    $data['messages'][$i]['quotedMsgType'],
                    $data['messages'][$i]['metadata'],
                    $data['messages'][$i]['ack'],
                    $data['messages'][$i]['chatName'],
                    $sender[$i]
                ));
                $i++;
            }

            $consulta = crud::Read(query::ReadMensajesChat($id));
            $i = 0;
            while ($row = mysqli_fetch_assoc($consulta)) {

                $Array[$i]['id']              =   $row['id'];
                $Array[$i]['body']            =   $row['body'];
                $Array[$i]['fromMe']          =   $row['fromMe'];
                $Array[$i]['isForwarded']     =   $row['isForwarded'];
                $Array[$i]['author']          =   $row['author'];
                $Array[$i]['time']            =   $row['time'];
                $Array[$i]['chatId']          =   $row['chatId'];
                $Array[$i]['messageNumber']   =   $row['messageNumber'];
                $Array[$i]['type']            =   $row['type'];
                $Array[$i]['senderName']      =   $row['senderName'];
                $Array[$i]['quotedMsgBody']   =   $row['quotedMsgBody'];
                $Array[$i]['quotedMsgId']     =   $row['quotedMsgId'];
                $Array[$i]['quotedMsgType']   =   $row['quotedMsgType'];
                $Array[$i]['metadata']        =   $row['metadata'];
                $Array[$i]['ack']             =   $row['ack'];
                $Array[$i]['chatName']        =   $row['chatName'];
                $Array[$i]['FechaHora']       =   $row['FechaHora'];
                $Array[$i]['sender']          =   str_replace('@c.us', '', $row['sender']);
                $i++;
            }

            print json_encode($Array, JSON_PRETTY_PRINT);
        }
    }

    //Enviar Mensajes de chat individual
    public static function EnviarMensajesChat()
    {
        $user = $_SESSION['Asistant'];
        //var_dump($consulta);
        $UrlToken = mysqli_fetch_assoc(crud::Read(query::ReadAwebT($user)));
        $Api = new ChatApi($UrlToken['Instance'], $UrlToken['Token']);
        $Phone = $_POST['chatId'];
        $message = $_POST['txtCuerpoMensage'];
        echo $Api->SendMenssage($Phone, $message);
        //echo $Phone.' '.$message;
    }
    ///////////////////////////////////
}
