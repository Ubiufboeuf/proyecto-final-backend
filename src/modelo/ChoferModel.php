<?php

require_once 'Conexion.php';

class ChoferModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarChofer($idOmnibus, $nombre, $telefono, $horasTrabajadas) {
        $sql = "INSERT INTO chofer (ID_Omnibus, Nombre, Telefono, Horas_Trabajadas) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isii", $idOmnibus, $nombre, $telefono, $horasTrabajadas);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Chofer registrado correctamente',
                'chofer_id' => $this->conn->insert_id
            ];
        }
        return ['success' => false, 'message' => 'Error al registrar chofer'];
    }
    
    public function obtenerChofer($id) {
        $sql = "SELECT c.*, o.`Tipo-Omnibus` as tipo_omnibus 
                FROM chofer c 
                LEFT JOIN omnibus o ON c.ID_Omnibus = o.ID_Omnibus 
                WHERE c.ID_Chofer = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return ['success' => true, 'data' => $result->fetch_assoc()];
        }
        return ['success' => false, 'message' => 'Chofer no encontrado'];
    }
}

?>