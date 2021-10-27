<?php 

function app_autoload($clases){
    require_once 'app/asistant/models/clases/'.$clases.'.php';
}

spl_autoload_register('app_autoload');


?>