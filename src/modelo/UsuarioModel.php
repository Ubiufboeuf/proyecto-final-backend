<?php
// modelo/UsuarioModel.php
require_once 'Conexion.php';

class UsuarioModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarUsuario($nombre, $contraseña, $correo) {
        // Verificar si el email ya existe
        $checkSql = "SELECT id FROM usuario WHERE email = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("s", $correo);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            return ['success' => false, 'message' => 'El email ya está registrado'];
        }
        
        // Registrar nuevo usuario
        $hashedPassword = password_hash($contraseña, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (nombre, password, correo) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $hashedPassword, $correo);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Usuario registrado correctamente', 'user_id' => $this->conn->insert_id];
        } else {
            return ['success' => false, 'message' => 'Error al registrar usuario'];
        }
    }

    public function loginUsuario($correo, $contraseña) {
        $sql = "SELECT ID_Usuario, nombre, correo, password FROM usuario WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($contraseña, $user['password'])) {
                return ['success' => true, 'user' => $user];
            }
        }
        return ['success' => false, 'message' => 'Credenciales inválidas'];
    }
    
    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT ID_Usuario, nombre, correo FROM usuario WHERE ID_Usuario = ?";
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