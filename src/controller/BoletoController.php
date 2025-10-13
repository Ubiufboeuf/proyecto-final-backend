<?php
require_once '../modelo/BoletoModel.php';

class BoletoController {
    private $model;
    
    public function __construct() {
        $this->model = new BoletoModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPersona = $_POST['id_persona'] ?? '';
            $idPago = $_POST['id_pago'] ?? '';
            $idOmnibus = $_POST['id_omnibus'] ?? '';
            $asiento = $_POST['asiento'] ?? '';
            $coche = $_POST['coche'] ?? '';
            $horaSalida = $_POST['hora_salida'] ?? '';
            $horaLlegada = $_POST['hora_llegada'] ?? '';
            $ciudadSalida = $_POST['ciudad_salida'] ?? '';
            $ciudadLlegada = $_POST['ciudad_llegada'] ?? '';
            $tipoOmnibus = $_POST['tipo_omnibus'] ?? '';
            
            if (empty($idPersona) || empty($idPago) || empty($idOmnibus)) {
                return json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
            }
            
            $result = $this->model->registrarBoleto(
                $idPersona, $idPago, $idOmnibus, $asiento, $coche,
                $horaSalida, $horaLlegada, $ciudadSalida, $ciudadLlegada, $tipoOmnibus
            );
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function obtener() {
        if (isset($_GET['id'])) {
            $result = $this->model->obtenerBoleto($_GET['id']);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
}

?>