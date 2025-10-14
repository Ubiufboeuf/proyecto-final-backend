<?php
require_once 'Conexion.php';

class ServicioModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarServicio($idUsuario, $idPago, $giros, $tramites, $lineaPasajes, $lineaAbono, $partidas) {
        $sql = "INSERT INTO servicios (ID_Usuario, ID_Pago, Giros, Tramites, 
                `Linea-Pasajes`, `Linea-Abono`, Partidas) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisssss", $idUsuario, $idPago, $giros, $tramites, 
                         $lineaPasajes, $lineaAbono, $partidas);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Servicio registrado correctamente',
                'servicio_id' => $this->conn->insert_id
            ];
        }
        return ['success' => false, 'message' => 'Error al registrar servicio'];
    }
    
    public function obtenerServicio($id) {
        $sql = "SELECT s.*, p.`NombreCompleto` as nombre_cliente
                FROM servicios s
                LEFT JOIN persona p ON s.ID_Usuario = p.ID_Usuario
                WHERE s.ID_Servicios = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return ['success' => true, 'data' => $result->fetch_assoc()];
        }
        return ['success' => false, 'message' => 'Servicio no encontrado'];
    }
}

?>