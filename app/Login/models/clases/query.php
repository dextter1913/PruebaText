<?php 

//Aqui van todos los querys de el servicio login
    class  query
    {
        public static function ValidacionLoginMaster($user, $pass){
            return "SELECT * FROM Usuarios WHERE usuario = '$user' AND password = '$pass' AND maestro = TRUE";
        }

        public static function ValidacionLoginAdmin($user, $pass){
            return "SELECT * FROM Usuarios WHERE usuario = '$user' AND password = '$pass' AND admin = TRUE AND maestro = FALSE";
        }

        public static function ValidacionLoginAsistant($user, $pass){
            return "SELECT * FROM Usuarios WHERE usuario = '$user' AND password = '$pass' AND admin = FALSE";
        }
    }
