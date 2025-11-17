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

            // Crear token de sesión aleatorio
            $token = bin2hex(random_bytes(32));

            // Guardar el token en la BD
            $update = $this->conn->prepare("UPDATE usuario SET token_sesion = ? WHERE ID_Usuario = ?");
            $update->bind_param("si", $token, $userId);
            $update->execute();

            return [
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'token' => $token
            ];
        } else {
            return ['success' => false, 'message' => 'Error al registrar usuario: ' . $this->conn->error];
        }
    }

    public function loginUsuario($contacto, $tipoContacto, $contrasenia) {
        // Orden:
        // 1. Buscar solo por email o teléfono
        // 2. luego validar contraseña (porque se guarda hasheada, así que buscando con ella nunca daría resultados)
        // 3. y luego (si todo es correcto) crear la cookie con el token

        $sql = $tipoContacto == 'email'
            ? "SELECT ID_Usuario, token_sesion, correo, contrasenia FROM usuario WHERE correo = ?"
            : "SELECT ID_Usuario, token_sesion, telefono, contrasenia FROM usuario WHERE telefono = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $contacto);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            return ['success' => false, 'message' => $tipoContacto == 'email'
                ? 'El correo no está registrado'
                : 'El teléfono no está registrado'];
        }

        if ($result->num_rows > 1) {
            // habria que guardar esto en el archivo de logs
            return ['success' => false, 'message' => 'Error interno: Usuario duplicado. Por favor, contacta al soporte'];
        }
        
        // Solo 1 resultado
        $user = $result->fetch_assoc();

        // validar contraseña
        if (!password_verify($contrasenia, $user['contrasenia'])) {
            return ['success' => false, 'message' => 'Contraseña incorrecta'];
        }

        $token = bin2hex(random_bytes(32));
        $update = $this->conn->prepare("UPDATE usuario SET token_sesion = ? WHERE ID_Usuario = ?");
        $update->bind_param("si", $token, $user['ID_Usuario']);
        $update->execute();

        return [
            'success' => true,
            'message' => 'Usuario registrado correctamente',
            'token' => $token
        ];
    }
    
    // public function obtenerUsuarioPorId($id) {
    //     $sql = "SELECT ID_Usuario, correo, telefono FROM usuario WHERE ID_Usuario = ?";
    //     $stmt = $this->conn->prepare($sql);
        
    //     if (!$stmt) {
    //         return null;
    //     }
        
    //     $stmt->bind_param("i", $id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
        
    //     if ($result->num_rows == 1) {
    //         return $result->fetch_assoc();
    //     }
    //     return null;
    // }

    // public function actualizarContraseña($idUsuario, $nuevaContrasenia) {
    //     $hashedPassword = password_hash($nuevaContrasenia, PASSWORD_DEFAULT);
    //     $sql = "UPDATE usuario SET contrasenia = ? WHERE ID_Usuario = ?";
    //     $stmt = $this->conn->prepare($sql);
        
    //     if (!$stmt) {
    //         return ['success' => false, 'message' => 'Error en la consulta: ' . $this->conn->error];
    //     }
        
    //     $stmt->bind_param("si", $hashedPassword, $idUsuario);
        
    //     if ($stmt->execute()) {
    //         return ['success' => true, 'message' => 'Contraseña actualizada correctamente'];
    //     }
    //     return ['success' => false, 'message' => 'Error al actualizar contraseña'];
    // }

    // public function actualizarTelefono($idUsuario, $telefono) {
    //     $sql = "UPDATE usuario SET telefono = ? WHERE ID_Usuario = ?";
    //     $stmt = $this->conn->prepare($sql);
        
    //     if (!$stmt) {
    //         return ['success' => false, 'message' => 'Error en la consulta: ' . $this->conn->error];
    //     }
        
    //     $stmt->bind_param("ii", $telefono, $idUsuario);
        
    //     if ($stmt->execute()) {
    //         return ['success' => true, 'message' => 'Teléfono actualizado correctamente'];
    //     }
    //     return ['success' => false, 'message' => 'Error al actualizar teléfono'];
    // }
}

?>