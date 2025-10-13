<?php
require_once 'Conexion.php';

class RutaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarRuta($origen, $destino, $paradas, $idOmnibus) {
        $sql = "INSERT INTO ruta (Origen, Destino, Paradas, ID_Omnibus) 
                VALUES (ST_GeomFromText(?), ST_GeomFromText(?), ST_GeomFromText(?), ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $origen, $destino, $paradas, $idOmnibus);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Ruta registrada correctamente',
                'ruta_id' => $this->conn->insert_id
            ];
        }
        return ['success' => false, 'message' => 'Error al registrar ruta'];
    }
    
    public function obtenerRuta($id) {
        $sql = "SELECT r.ID_Rutas, 
                ST_AsText(r.Origen) as Origen,
                ST_AsText(r.Destino) as Destino,
                ST_AsText(r.Paradas) as Paradas,
                o.`Tipo-Omnibus` as tipo_omnibus
                FROM ruta r
                LEFT JOIN omnibus o ON r.ID_Omnibus = o.ID_Omnibus
                WHERE r.ID_Rutas = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return ['success' => true, 'data' => $result->fetch_assoc()];
        }
        return ['success' => false, 'message' => 'Ruta no encontrada'];
    }
}

?>