<?php
class ChatApi
{
    private $instance;
    private $token;

    public function __construct($instance, $token)
    {
        $this->instance = $instance;
        $this->token = $token;
    }

    //Metodo para envio de mensajes
    public function SendMenssage($phone, $body)
    {
        $data = [
            'phone' => $phone,
            'body' => $body,
        ];

        $json = json_encode($data);
        $url = $this->instance . 'message?token=' . $this->token;

        $options = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => $json
            ]
        ]);
        $result = file_get_contents($url, false, $options);
        return $result;
    }

    //Metodo para Consultar salas de chat
    public function Dialogs()
    {
        $url = $this->instance . 'dialogs?token=' . $this->token . '&page=1&order=desc';
        $result = file_get_contents($url);
        $Dialogs = json_decode($result, true);
        return $Dialogs;
    }

    //Metodo para consultar todos los mensajes
    public function messages()
    {
        $token = $this->token;
        $instanceId = $this->instance;
        $url = $instanceId . 'messages?token=' . $token;
        $result = file_get_contents($url); // Send a request
        $data = json_decode($result, 1); // Parse JSON
        return $data;
    }
}
