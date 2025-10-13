<?php
require_once 'Conexion.php';

class EncomiendaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarEncomienda($idOmnibus, $tipo, $telefono) {
        $sql = "INSERT INTO encomiendas (ID_Omnibus, Tipo, Telefono) 
                VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $idOmnibus, $tipo, $telefono);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Encomienda registrada correctamente',
                'encomienda_id' => $this->conn->insert_id
            ];
        }
        return ['success' => false, 'message' => 'Error al registrar encomienda'];
    }
    
    public function obtenerEncomienda($id) {
        $sql = "SELECT e.*, o.`Tipo-Omnibus` as tipo_omnibus
                FROM encomiendas e
                LEFT JOIN omnibus o ON e.ID_Omnibus = o.ID_Omnibus
                WHERE e.ID_Encomienda = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return ['success' => true, 'data' => $result->fetch_assoc()];
        }
        return ['success' => false, 'message' => 'Encomienda no encontrada'];
    }
}

?>