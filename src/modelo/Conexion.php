<?php
require_once __DIR__ . '/../../Log.php';
// modelo/Conexion.php
function connection() {
    try {
        $host = "localhost";
        $bd = "bdproyectofinal";
        $usuario = "root";
        $password = "";
        $puerto = "3306";
        $mysqli = new mysqli($host, $usuario, $password, $bd, $puerto);
        return $mysqli;
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
