<?php
require_once 'Conexion.php';

class PagoModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarPago($fecha, $monto, $idPersona, $metodoPago) {
        $sql = "INSERT INTO pago (Fecha, Monto, ID_Persona, `Metodo-Pago`, Estado) 
                VALUES (?, ?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $fecha, $monto, $idPersona, $metodoPago);
        
        if ($stmt->execute()) {
            return [
                'success' => true, 
                'message' => 'Pago registrado correctamente',
                'pago_id' => $this->conn->insert_id
            ];
        } else {
            return ['success' => false, 'message' => 'Error al registrar pago'];
        }
    }
    
    public function obtenerPago($id) {
        $sql = "SELECT p.*, per.`Nombre-Completo` as nombre_cliente 
                FROM pago p 
                JOIN persona per ON p.ID_Persona = per.ID_Usuario 
                WHERE p.ID_Pago = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return ['success' => true, 'data' => $result->fetch_assoc()];
        }
        return ['success' => false, 'message' => 'Pago no encontrado'];
    }
    
    public function actualizarEstadoPago($id, $estado) {
        $sql = "UPDATE pago SET Estado = ? WHERE ID_Pago = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $estado, $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Estado de pago actualizado'];
        }
        return ['success' => false, 'message' => 'Error al actualizar estado'];
    }
    
    public function obtenerPagosPorUsuario($idUsuario) {
        $sql = "SELECT p.*, per.`Nombre-Completo` as nombre_cliente 
                FROM pago p 
                JOIN persona per ON p.ID_Persona = per.ID_Usuario 
                WHERE p.ID_Persona = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return ['success' => true, 'data' => $result->fetch_all(MYSQLI_ASSOC)];
    }
}

?>