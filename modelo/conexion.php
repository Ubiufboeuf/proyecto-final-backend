<?php
//Deshabilitar la visualización de errores
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// Habilitar el registro de errores
ini_set('log_errors', '1');
ini_set('error_log', '../log/php_errors.log');
function connection()
{
    try {
        $host = "localhost";
        $usuario = "root";
        //  $password = "Centos2023.";
        $password = "";
        $bd = "utu-np";
        $puerto = 3306;
        $mysql = new mysqli($host, $usuario, $password, $bd, $puerto);
        return $mysql;
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error; //return
    }
}
