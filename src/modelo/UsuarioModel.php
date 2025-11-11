<?php

require_once 'Conexion.php';

class UsuarioModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarUsuario($correo, $telefono, $contrasenia) {
        // Verificar si el correo ya existe
        $checkSql = "SELECT ID_Usuario FROM usuario WHERE correo = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("s", $correo);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            return ['success' => false, 'message' => 'El correo ya está registrado'];
        }
        
        // Hashear la contraseña
        $hashedPassword = password_hash($contrasenia, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (correo, telefono, contrasenia) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sis", $correo, $telefono, $hashedPassword);

        if ($stmt->execute()) {
            return [
                'success' => true, 
                'message' => 'Usuario registrado correctamente',
                'user_id' => $this->conn->insert_id
            ];
        } else {
            return ['success' => false, 'message' => 'Error al registrar usuario'];
        }
    }

    public function loginUsuario($correo, $contrasenia) {
        $sql = "SELECT ID_Usuario, correo, telefono, contrasenia FROM usuario WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($contrasenia, $user['contrasenia'])) {
                unset($user['contrasenia']); // No enviar la contraseña en la respuesta
                return ['success' => true, 'user' => $user];
            }
        }
        return ['success' => false, 'message' => 'Credenciales inválidas'];
    }
    
    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT ID_Usuario, correo, telefono FROM usuario WHERE ID_Usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function actualizarContraseña($idUsuario, $nuevaContrasenia) {
        $hashedPassword = password_hash($nuevaContrasenia, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET contrasenia = ? WHERE ID_Usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $idUsuario);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Contraseña actualizada correctamente'];
        }
        return ['success' => false, 'message' => 'Error al actualizar contraseña'];
    }

    public function actualizarTelefono($idUsuario, $telefono) {
        $sql = "UPDATE usuario SET telefono = ? WHERE ID_Usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $telefono, $idUsuario);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Teléfono actualizado correctamente'];
        }
        return ['success' => false, 'message' => 'Error al actualizar teléfono'];
    }
}

?>