<?php
require_once  'conexion.php';


class inasistencia
{


function obtener(){
    $connection = connection();
    $fechaActual = date('Y-m-d'); 
    $sql = "SELECT * FROM inasistencia WHERE fechaFin >= '$fechaActual' ORDER BY fechaIni ASC";

    $respuesta = $connection->query($sql);
    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    return $resultado;
}
function obtenerTodos(){
    $connection = connection();
    $fechaActual = date('Y-m-d'); 
    $sql = "SELECT *, CASE WHEN fechaFin >= '$fechaActual' THEN 'Activo' ELSE 'Finalizado' END AS estado FROM inasistencia ORDER BY fechaIni ASC";

    $respuesta = $connection->query($sql);
    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    return $resultado;
   
}

function obtenerTodosOrdenados($columna, $orden){
    $connection = connection();
    $fechaActual = date('Y-m-d'); 
    $sql = "SELECT *, CASE WHEN fechaFin >= '$fechaActual' THEN 'Activo' ELSE 'Finalizado' END AS estado FROM inasistencia ORDER BY $columna $orden";

    $respuesta = $connection->query($sql);
    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    return $resultado;
   
}


function obtenerFinalizados(){
    $connection = connection();
    $fechaActual = date('Y-m-d'); 
    $sql = "SELECT * FROM inasistencia WHERE fechaFin < '$fechaActual' ORDER BY fechaIni ASC";

    $respuesta = $connection->query($sql);
    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    return $resultado;
}
public function obtenerFinalizadosOrdenados($columna, $orden)
{
    $connection = connection();
    $fechaActual = date('Y-m-d');
    $sql = "SELECT * FROM inasistencia WHERE fechaFin < '$fechaActual' ORDER BY $columna $orden";
    $respuesta = $connection->query($sql);
    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    return $resultado;
}

public function obtenerOrdenados($columna, $orden)
{
    $connection = connection();
    $sql = "SELECT * FROM inasistencia ORDER BY $columna $orden";
    $respuesta = $connection->query($sql);
    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    return $resultado;
}

function obtenerAnteriores(){
    $connection = connection();
    $fechaActual = date('Y-m-d'); 
    $sql = "SELECT * FROM inasistencia WHERE fechaFin<'$fechaActual' ORDER BY fechaIni ASC";

    $respuesta = $connection->query($sql);
    $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
    return $resultado;
}

function agregar($docente, $fechaIni, $fechaFin, $motivo){
    $sql = "INSERT INTO inasistencia VALUES (null, '$docente', '$fechaIni', '$fechaFin', '$motivo')";
    $connection = connection();
    $respuesta = $connection->query($sql);

    if ($respuesta) {
        return 'Inasistencia agregada';
    } else {
        return '¡Error al agregar inasistencia!';
    }
}


function modificar ($id, $docente, $fechaIni, $fechaFin, $motivo){
    $sql = "UPDATE inasistencia SET docente = '$docente', fechaIni = '$fechaIni', fechaFin = '$fechaFin', motivo = '$motivo' WHERE id = $id;";
    $connection = connection();
    $respuesta = $connection->query($sql);

    if ($respuesta) {
        return 'Paciente agregado';
    } else {
        return '¡Error al agregar paciente!';
    }

}

function eliminar($id){
    $sql = "DELETE FROM inasistencia WHERE id = '$id'";
    $connection = connection();
    $respuesta = $connection->query($sql);
    if ($respuesta) {
        return 'Paciente agregado';
    } else {
        return '¡Error al agregar paciente!';
    }
}

}

?>