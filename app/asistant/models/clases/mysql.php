<?php 

class mysql {
    private $host;
    private $user;
    private $pass;
    private $db;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pass = '';
        $this->db = 'whatsapp';
    }

    public function Conexion()
    {
        $mysql = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if ($mysql->mysqli_connect_errno) {
            echo 'Error de conexion';
            
        } elseif ($mysql->set_charset('utf8')) {
            return $mysql;
        }
    }

    public function __destruct()
    {
        mysqli_close($this->Conexion());
    }
}
