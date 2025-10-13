<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Log.php';
require_once __DIR__ . '/controller/UsuarioController.php';
require_once __DIR__ . '/modelo/Conexion.php';
require_once __DIR__ . '/modelo/UsuarioModel.php';

// Main script to handle HTTP requests
header('Content-Type: application/json');
session_start();

$action = $_GET['action'] ?? '';

$controller = new UsuarioController();

switch ($action) {
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
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}
?>