<?php
require_once __DIR__ . '/Conexion.php';

class UsuarioModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connection();
    }
    
    public function registrarUsuario($nombre_completo, $documento, $contrasenia, $contacto, $tipoContacto) {
        // Verificar si el correo ya existe
        $checkSql = $tipoContacto == 'email'
            ? "SELECT ID_Usuario FROM usuario WHERE correo = ?"
            : "SELECT ID_Usuario FROM usuario WHERE telefono = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        
        // Enlazamos las variables: correo, telefono, documento.
        $checkStmt->bind_param("s", $contacto);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            return [
                'success' => false,
                'message' => $tipoContacto == 'email'
                    ? 'El correo ya está registrado'
                    : 'El teléfono ya está registrado'
            ];
        }
        
        // Hashear la contraseña (aumentar tamaño de contrasenia en BD a varchar(255))
        $hashedPassword = password_hash($contrasenia, PASSWORD_DEFAULT);
        
        $correo = $tipoContacto == 'email' ? $contacto : '';
        $telefono = $tipoContacto == 'phone' ? $contacto : '';
        
        // Insertar usuario con ID auto-generado
        $sql = "INSERT INTO usuario (nombre_completo, documento, correo, telefono, contrasenia) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssss",
            $nombre_completo,
            $documento,
            $correo,
            $telefono,
            $hashedPassword
        );

        if ($stmt->execute()) {
            $userId = $this->conn->insert_id;
            return [
                'success' => true,
                
                'message' => 'Usuario registrado correctamente',
                'user_id' => $userId
            ];
        } else {
            return ['success' => false, 'message' => 'Error al registrar usuario: ' . $this->conn->error];
        }
    }

    public function loginUsuario($correo, $contrasenia) {
        $sql = "SELECT ID_Usuario, correo, telefono, contrasenia FROM usuario WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . $this->conn->error];
        }
        
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($contrasenia, $user['contrasenia'])) {
                unset($user['contrasenia']);
                return ['success' => true, 'user' => $user];
            } else {
                return ['success' => false, 'message' => 'Contraseña incorrecta'];
            }
        }
        return ['success' => false, 'message' => 'El correo no está registrado'];
    }
    
    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT ID_Usuario, correo, telefono FROM usuario WHERE ID_Usuario = ?";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            return null;
        }
        
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
        
        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . $this->conn->error];
        }
        
        $stmt->bind_param("si", $hashedPassword, $idUsuario);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Contraseña actualizada correctamente'];
        }
        return ['success' => false, 'message' => 'Error al actualizar contraseña'];
    }

    public function actualizarTelefono($idUsuario, $telefono) {
        $sql = "UPDATE usuario SET telefono = ? WHERE ID_Usuario = ?";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . $this->conn->error];
        }
        
        $stmt->bind_param("ii", $telefono, $idUsuario);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Teléfono actualizado correctamente'];
        }
        return ['success' => false, 'message' => 'Error al actualizar teléfono'];
    }
}

?>