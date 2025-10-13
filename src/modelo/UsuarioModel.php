<?php
require_once 'Conexion.php';

class UsuarioModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarUsuario($idUsuario, $contraseña) {
        // Registrar nuevo usuario
        $hashedPassword = password_hash($contraseña, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (ID_Usuario, Contrasena) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $idUsuario, $hashedPassword);

        if ($stmt->execute()) {
            return [
                'success' => true, 
                'message' => 'Usuario registrado correctamente',
                'user_id' => $idUsuario
            ];
        } else {
            return ['success' => false, 'message' => 'Error al registrar usuario'];
        }
    }

    public function loginUsuario($idUsuario, $contraseña) {
        $sql = "SELECT ID_Usuario, Contrasena FROM usuario WHERE ID_Usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($contraseña, $user['Contrasena'])) {
                unset($user['Contrasena']); // No enviar la contraseña en la respuesta
                return ['success' => true, 'user' => $user];
            }
        }
        return ['success' => false, 'message' => 'Credenciales inválidas'];
    }
    
    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT ID_Usuario FROM usuario WHERE ID_Usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return null;
    }
}

?>