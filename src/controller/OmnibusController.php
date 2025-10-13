<?php
require_once '../modelo/OmnibusModel.php';

class OmnibusController {
    private $model;
    
    public function __construct() {
        $this->model = new OmnibusModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idChofer = $_POST['id_chofer'] ?? '';
            $proximaParada = $_POST['proxima_parada'] ?? '';
            $ultimaParada = $_POST['ultima_parada'] ?? '';
            $coordenadas = $_POST['coordenadas'] ?? '';
            $tipoOmnibus = $_POST['tipo_omnibus'] ?? '';
            
            if (empty($idChofer) || empty($proximaParada) || empty($tipoOmnibus)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Todos los campos son requeridos'
                ]);
            }
            
            $result = $this->model->registrarOmnibus(
                $idChofer,
                $proximaParada,
                $ultimaParada,
                $coordenadas,
                $tipoOmnibus
            );
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function obtener() {
        if (isset($_GET['id'])) {
            $result = $this->model->obtenerOmnibus($_GET['id']);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
    
    public function actualizarUbicacion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $proximaParada = $_POST['proxima_parada'] ?? '';
            $coordenadas = $_POST['coordenadas'] ?? '';
            
            if (empty($id) || empty($proximaParada) || empty($coordenadas)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Todos los campos son requeridos'
                ]);
            }
            
            $result = $this->model->actualizarUbicacion($id, $proximaParada, $coordenadas);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function listar() {
        $result = $this->model->listarOmnibus();
        return json_encode($result);
    }
}

?>