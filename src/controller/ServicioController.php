<?php
require_once '../modelo/ServicioModel.php';

class ServicioController {
    private $model;
    
    public function __construct() {
        $this->model = new ServicioModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['id_usuario'] ?? '';
            $idPago = $_POST['id_pago'] ?? '';
            $giros = $_POST['giros'] ?? '';
            $tramites = $_POST['tramites'] ?? '';
            $lineaPasajes = $_POST['linea_pasajes'] ?? '';
            $lineaAbono = $_POST['linea_abono'] ?? '';
            $partidas = $_POST['partidas'] ?? '';
            
            if (empty($idUsuario) || empty($idPago)) {
                return json_encode([
                    'success' => false,
                    'message' => 'ID de usuario y pago son requeridos'
                ]);
            }
            
            $result = $this->model->registrarServicio(
                $idUsuario, 
                $idPago,
                $giros,
                $tramites,
                $lineaPasajes,
                $lineaAbono,
                $partidas
            );
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function obtener() {
        if (isset($_GET['id'])) {
            $result = $this->model->obtenerServicio($_GET['id']);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
    
    public function obtenerPorUsuario() {
        if (isset($_GET['id_usuario'])) {
            $result = $this->model->obtenerServicio($_GET['id_usuario']); //Obtiene el servicio por ID de usuario!
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado']);
    }
}

?>