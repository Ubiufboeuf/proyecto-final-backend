<?php
require_once 'Conexion.php';

class BoletoModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarBoleto($idPersona, $idPago, $idOmnibus, $asiento, $coche, 
                                  $horaSalida, $horaLlegada, $ciudadSalida, $ciudadLlegada, $tipoOmnibus) {
        $sql = "INSERT INTO boleto (ID_Persona, ID_Pago, ID_Omnibus, Asiento, Coche, 
                `HoraSalida`, `HoraLlegada`, `CiudadSalida`, `CiudadLlegada`, `TipoOmnibus`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiiiiissss", $idPersona, $idPago, $idOmnibus, $asiento, $coche,
                         $horaSalida, $horaLlegada, $ciudadSalida, $ciudadLlegada, $tipoOmnibus);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Boleto registrado correctamente', 
                    'boleto_id' => $this->conn->insert_id];
        } else {
            return ['success' => false, 'message' => 'Error al registrar boleto'];
        }
    }
    
    public function obtenerBoleto($id) {
        $sql = "SELECT b.*, p.`NombreCompleto` as nombre_pasajero 
                FROM boleto b 
                JOIN persona p ON b.ID_Persona = p.ID_Usuario 
                WHERE b.ID_Boleto = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return ['success' => true, 'data' => $result->fetch_assoc()];
        }
        return ['success' => false, 'message' => 'Boleto no encontrado'];
    }
}
?>