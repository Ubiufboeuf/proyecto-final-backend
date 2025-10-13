<?php

require_once 'Conexion.php';

class OmnibusModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarOmnibus($idChofer, $proximaParada, $ultimaParada, $coordenadas, $tipoOmnibus) {
        $sql = "INSERT INTO omnibus (`ID_Chofer`, `Proxima-Parada`, `Ultima-Parada`, 
                `Coordenadas`, `Tipo-Omnibus`) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issss", $idChofer, $proximaParada, $ultimaParada, 
                         $coordenadas, $tipoOmnibus);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Omnibus registrado correctamente',
                'omnibus_id' => $this->conn->insert_id
            ];
        }
        return ['success' => false, 'message' => 'Error al registrar omnibus'];
    }
    
    public function obtenerOmnibus($id) {
        $sql = "SELECT o.*, c.Nombre as nombre_chofer, c.Telefono as telefono_chofer 
                FROM omnibus o 
                LEFT JOIN chofer c ON o.ID_Chofer = c.ID_Chofer 
                WHERE o.ID_Omnibus = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return ['success' => true, 'data' => $result->fetch_assoc()];
        }
        return ['success' => false, 'message' => 'Omnibus no encontrado'];
    }
    
    public function actualizarUbicacion($id, $proximaParada, $coordenadas) {
        $sql = "UPDATE omnibus SET `Proxima-Parada` = ?, `Coordenadas` = ? 
                WHERE ID_Omnibus = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $proximaParada, $coordenadas, $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Ubicación actualizada correctamente'];
        }
        return ['success' => false, 'message' => 'Error al actualizar ubicación'];
    }
    
    public function listarOmnibus() {
        $sql = "SELECT o.*, c.Nombre as nombre_chofer 
                FROM omnibus o 
                LEFT JOIN chofer c ON o.ID_Chofer = c.ID_Chofer";
        $result = $this->conn->query($sql);
        
        if ($result) {
            return ['success' => true, 'data' => $result->fetch_all(MYSQLI_ASSOC)];
        }
        return ['success' => false, 'message' => 'Error al obtener la lista de omnibus'];
    }
}

?>