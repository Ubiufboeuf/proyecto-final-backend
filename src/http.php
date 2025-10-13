<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Log.php';
require_once __DIR__ . '/controller/UsuarioController.php';
require_once __DIR__ . '/modelo/UsuarioModel.php';

// Main script to handle HTTP requests
header('Content-Type: application/json');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
session_start();

$action = $_GET['action'] ?? '';

$controller = new UsuarioController();

switch ($action) {

    //Usuario acciones:
    case 'registrar':
        echo $controller->registrar();
        break;
    case 'login':
        echo $controller->login();
        break;
    case 'logout':
        echo $controller->logout();
        break;
    case 'verificarSesion':
        echo $controller->verificarSesion();
        break;

    //Boleto acciones:
    case 'registrarBoleto':
        echo $boletoController->registrar();
        break;
    case 'obtenerBoleto':
        echo $boletoController->obtener();
        break;

    //Pago acciones:
    case 'registrarPago':
        echo $pagoController->registrar();
        break;
    case 'obtenerPago':
        echo $pagoController->obtener();
        break;
    case 'actualizarEstadoPago':
        echo $pagoController->actualizarEstado();
        break;
    case 'obtenerPagosPorUsuario':
        echo $pagoController->obtenerPorUsuario();
        break;

    //Omnibus acciones:
    case 'registrarOmnibus':
        echo $omnibusController->registrar();
        break;
    case 'obtenerOmnibus':
        echo $omnibusController->obtener();
        break;
    case 'actualizarUbicacionOmnibus':
        echo $omnibusController->actualizarUbicacion();
        break;
    case 'listarOmnibus':
        echo $omnibusController->listar();
        break;

    //Ruta acciones:
    case 'registrarRuta':
        echo $rutaController->registrar();
        break;
    case 'obtenerRuta':
        echo $rutaController->obtener();
        break;     

    //Servicio acciones:
    case 'registrarServicio':
        echo $servicioController->registrar();
        break;
    case 'obtenerServicio':
        echo $servicioController->obtener();
        break;
    case 'obtenerServiciosPorUsuario':
        echo $servicioController->obtenerPorUsuario();
        break;
      
    //Encomienda acciones:
    case 'registrarEncomienda':
        echo $encomiendaController->registrar();
        break;
    case 'obtenerEncomienda':
        echo $encomiendaController->obtener();
        break;
    case 'listarEncomiendasPorOmnibus':
        echo $encomiendaController->listarPorOmnibus();
        break;
    
    //Default case:
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}
?>