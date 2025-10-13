<?php
// controller/UsuarioController.php
require_once '../modelo/UsuarioModel.php';
session_start();

class UsuarioController {
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($nombre) || empty($email) || empty($password)) {
                return json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
            }
            
            $model = new UsuarioModel();
            $result = $model->registrarUsuario($nombre, $email, $password);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                return json_encode(['success' => false, 'message' => 'Email y contraseña son requeridos']);
            }
            
            $model = new UsuarioModel();
            $result = $model->loginUsuario($email, $password);
            
            if ($result['success']) {
                $_SESSION['user_id'] = $result['user']['ID_Usuario'];
                $_SESSION['user_name'] = $result['user']['nombre'];
                return json_encode(['success' => true, 'message' => 'Login exitoso']);
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
            return json_encode(['logged_in' => true, 'user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name']]);
        }
        return json_encode(['logged_in' => false]);
    }
}
?>