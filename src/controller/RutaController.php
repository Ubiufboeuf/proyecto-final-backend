<?php
require_once '../modelo/RutaModel.php';

class RutaController {
    private $model;
    
    public function __construct() {
        $this->model = new RutaModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $origen = $_POST['origen'] ?? '';
            $destino = $_POST['destino'] ?? '';
            $paradas = $_POST['paradas'] ?? '';
            $idOmnibus = $_POST['id_omnibus'] ?? '';
            
            if (empty($origen) || empty($destino) || empty($idOmnibus)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Origen, destino y ID de ómnibus son requeridos'
                ]);
            }
            
            $result = $this->model->registrarRuta($origen, $destino, $paradas, $idOmnibus);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function obtener() {
        if (isset($_GET['id'])) {
            $result = $this->model->obtenerRuta($_GET['id']);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
}

?>