<?php
require_once __DIR__ . '/../modelo/UsuarioModel.php';
session_start();

class UsuarioController {
    private $model;
    
    public function __construct() {
        $this->model = new UsuarioModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $contrasenia = $_POST['contrasenia'] ?? '';
            
            // Validaciones
            if (empty($correo) || empty($telefono) || empty($contrasenia)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'Correo, teléfono y contraseña son requeridos'
                ]);
            }
            
            // Validar formato de correo
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'El correo no es válido'
                ]);
            }
            
            // Validar que el teléfono sea un número
            if (!is_numeric($telefono)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'El teléfono debe ser un número'
                ]);
            }
            
            // Validar que la contraseña tenga mínimo 6 caracteres
            if (strlen($contrasenia) < 6) {
                return json_encode([
                    'success' => false, 
                    'message' => 'La contraseña debe tener al menos 6 caracteres'
                ]);
            }
            
            $result = $this->model->registrarUsuario($correo, $telefono, $contrasenia);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $contrasenia = $_POST['contrasenia'] ?? '';
            
            if (empty($correo) || empty($contrasenia)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'Correo y contraseña son requeridos'
                ]);
            }
            
            $result = $this->model->loginUsuario($correo, $contrasenia);
            
            if ($result['success']) {
                $_SESSION['user_id'] = $result['user']['ID_Usuario'];
                $_SESSION['user_email'] = $result['user']['correo'];
                return json_encode([
                    'success' => true, 
                    'message' => 'Login exitoso',
                    'user' => $result['user']
                ]);
            }
            
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function logout() {
        session_destroy();
        return json_encode(['success' => true, 'message' => 'Sesión cerrada']);
    }
    
    public function verificarSesion() {
        if (isset($_SESSION['user_id'])) {
            $userData = $this->model->obtenerUsuarioPorId($_SESSION['user_id']);
            if ($userData) {
                return json_encode([
                    'logged_in' => true,
                    'user' => $userData
                ]);
            }
        }
        return json_encode(['logged_in' => false]);
    }

    public function actualizarContraseña() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                return json_encode([
                    'success' => false, 
                    'message' => 'Usuario no autenticado'
                ]);
            }

            $nuevaContrasenia = $_POST['nueva_contrasenia'] ?? '';
            
            if (empty($nuevaContrasenia)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'Nueva contraseña es requerida'
                ]);
            }
            
            if (strlen($nuevaContrasenia) < 6) {
                return json_encode([
                    'success' => false, 
                    'message' => 'La contraseña debe tener al menos 6 caracteres'
                ]);
            }
            
            $result = $this->model->actualizarContraseña($_SESSION['user_id'], $nuevaContrasenia);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }

    public function actualizarTelefono() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                return json_encode([
                    'success' => false, 
                    'message' => 'Usuario no autenticado'
                ]);
            }

            $telefono = $_POST['telefono'] ?? '';
            
            if (empty($telefono) || !is_numeric($telefono)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'Teléfono válido es requerido'
                ]);
            }
            
            $result = $this->model->actualizarTelefono($_SESSION['user_id'], $telefono);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
}

?>