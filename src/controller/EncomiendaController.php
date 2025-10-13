<?php
require_once '../modelo/EncomiendaModel.php';

class EncomiendaController {
    private $model;
    
    public function __construct() {
        $this->model = new EncomiendaModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idOmnibus = $_POST['id_omnibus'] ?? '';
            $tipo = $_POST['tipo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            
            if (empty($idOmnibus) || empty($tipo) || empty($telefono)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Todos los campos son requeridos'
                ]);
            }
            
            $result = $this->model->registrarEncomienda($idOmnibus, $tipo, $telefono);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function obtener() {
        if (isset($_GET['id'])) {
            $result = $this->model->obtenerEncomienda($_GET['id']);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
    
    public function listarPorOmnibus() {
        if (isset($_GET['id_omnibus'])) {
            $result = $this->model->obtenerEncomienda($_GET['id_omnibus']); //Obtiene encomienda por omnibus! (Id_omnibus)
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID de ómnibus no proporcionado']);
    }
}

?>