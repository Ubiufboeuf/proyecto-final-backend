<?php

require_once '../modelo/ChoferModel.php';

class ChoferController {
    private $model;
    
    public function __construct() {
        $this->model = new ChoferModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idOmnibus = $_POST['id_omnibus'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $horasTrabajadas = $_POST['horas_trabajadas'] ?? 0;
            
            if (empty($nombre) || empty($telefono)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Nombre y teléfono son requeridos'
                ]);
            }
            
            $result = $this->model->registrarChofer($idOmnibus, $nombre, $telefono, $horasTrabajadas);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function obtener() {
        if (isset($_GET['id'])) {
            $result = $this->model->obtenerChofer($_GET['id']);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
}

?>