<?php

require_once __DIR__ . '/../Log.php';

require_once __DIR__ . '/controller/BoletoController.php';
require_once __DIR__ . '/controller/ChoferController.php';
require_once __DIR__ . '/controller/EncomiendaController.php';
require_once __DIR__ . '/controller/OmnibusController.php';
require_once __DIR__ . '/controller/PagoController.php';
require_once __DIR__ . '/controller/RutaController.php';
require_once __DIR__ . '/controller/ServicioController.php';
require_once __DIR__ . '/controller/UsuarioController.php';

// Main script to handle HTTP requests
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
session_start();

// Inicializar todos los controladores
$usuarioController = new UsuarioController();
$boletoController = new BoletoController();
$choferController = new ChoferController();
$encomiendaController = new EncomiendaController();
$omnibusController = new OmnibusController();
$pagoController = new PagoController();
$rutaController = new RutaController();
$servicioController = new ServicioController();

$action = $_GET['action'] ?? '';

switch ($action) {
    //Usuario acciones:
    case 'registrar':
        echo $usuarioController->registrar();
        break;
    case 'login':
        echo $usuarioController->login();
        break;
    case 'logout':
        echo $usuarioController->logout();
        break;
    case 'verificarSesion':
        echo $usuarioController->verificarSesion();
        break;
    case 'actualizarContrasenia':
        echo $usuarioController->actualizarContraseña();
        break;
    case 'actualizarTelefono':
        echo $usuarioController->actualizarTelefono();
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

    //Chofer acciones:
    case 'registrarChofer':
        echo $choferController->registrar();
        break;
    case 'obtenerChofer':
        echo $choferController->obtener();
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