<?php
require_once '../modelo/PagoModel.php';

class PagoController {
    private $model;
    
    public function __construct() {
        $this->model = new PagoModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha = $_POST['fecha'] ?? '';
            $monto = $_POST['monto'] ?? '';
            $idPersona = $_POST['id_persona'] ?? '';
            $metodoPago = $_POST['metodo_pago'] ?? '';
            
            if (empty($fecha) || empty($monto) || empty($idPersona) || empty($metodoPago)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'Todos los campos son requeridos'
                ]);
            }
            
            $result = $this->model->registrarPago($fecha, $monto, $idPersona, $metodoPago);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function obtener() {
        if (isset($_GET['id'])) {
            $result = $this->model->obtenerPago($_GET['id']);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
    
    public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $estado = $_POST['estado'] ?? '';
            
            if (empty($id) || empty($estado)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'ID y estado son requeridos'
                ]);
            }
            
            $result = $this->model->actualizarEstadoPago($id, $estado);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function obtenerPorUsuario() {
        if (isset($_GET['id_usuario'])) {
            $result = $this->model->obtenerPagosPorUsuario($_GET['id_usuario']);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado']);
    }
}

?>