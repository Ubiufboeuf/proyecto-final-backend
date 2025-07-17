<?php
// Permitir solicitudes solo desde el origen específico
header("Access-Control-Allow-Origin: http://localhost");
// Permitir el envío de cookies desde un origen diferente
header("Access-Control-Allow-Credentials: true");
// Permitir los métodos HTTP especificados (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir los encabezados HTTP especificados
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../modelo/inasistenciaDAO.php';


//if (isset($_SESSION['sesion'])) {
$funcion = $_GET['funcion'];
switch ($funcion) {
    case "agregar":
        agregar();
        break;
    case "modificar":
        modificar();
        break;
    case "eliminar":
        eliminar();
        break;
    case "obtener":
        obtener();
        break;
    case "obtenerOrdenados":
        obtenerOrdenados();
        break;
    case "obtenerFinalizados":
        obtenerFinalizados();
        break;
    case "obtenerFinalizadosOrdenados":
        obtenerFinalizadosOrdenados();
        break;
    case "obtenerTodos":
        obtenerTodos();
        break;
    case "obtenerTodosOrdenados":
        obtenerTodosOrdenados();
        break;
}




function obtener()
{

    $resultado = (new inasistencia())->obtener();
    echo json_encode($resultado);
}

function obtenerTodos()
{

    $resultado = (new inasistencia())->obtenerTodos();
    echo json_encode($resultado);
}

function obtenerFinalizados()
{

    $resultado = (new inasistencia())->obtenerFinalizados();
    echo json_encode($resultado);
}

function obtenerOrdenados()
{
    $columna = $_GET['columna'];
    $orden = $_GET['orden'];
    $resultado = (new inasistencia())->obtenerOrdenados($columna, $orden);
    echo json_encode($resultado);
}

function obtenerFinalizadosOrdenados()
{
    $columna = $_GET['columna'];
    $orden = $_GET['orden'];
    $resultado = (new inasistencia())->obtenerFinalizadosOrdenados($columna, $orden);
    echo json_encode($resultado);
}

function obtenerTodosOrdenados()
{
    $columna = $_GET['columna'];
    $orden = $_GET['orden'];
    $resultado = (new inasistencia())->obtenerTodosOrdenados($columna, $orden);
    echo json_encode($resultado);
}



function agregar()
{
    $docente = $_POST['docente'];
    $fechaIni = $_POST['fechaIni'];
    $fechaFin = $_POST['fechaFin'];
    $motivo = $_POST['motivo'];

    $resultado = (new inasistencia())->agregar($docente, $fechaIni, $fechaFin, $motivo);
    echo json_encode($resultado);
}

function modificar()
{
    $id = $_POST['id'];
    $docente = $_POST['docente'];
    $fechaIni = $_POST['fechaIni'];
    $fechaFin = $_POST['fechaFin'];
    $motivo = $_POST['motivo'];
    $resultado = (new inasistencia())->modificar($id, $docente, $fechaIni, $fechaFin, $motivo);
    echo json_encode($resultado);
}

function eliminar()
{
    $id = $_GET['id'];
    $resultado = (new inasistencia())->eliminar($id);
    echo json_encode($resultado);
}
