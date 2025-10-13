<?php
require_once '../modelo/UsuarioModel.php';
session_start();

class UsuarioController {
    private $model;
    
    public function __construct() {
        $this->model = new UsuarioModel();
    }
    
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['id_usuario'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($idUsuario) || empty($password)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'ID de usuario y contraseña son requeridos'
                ]);
            }
            
            $result = $this->model->registrarUsuario($idUsuario, $password);
            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['id_usuario'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($idUsuario) || empty($password)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'ID de usuario y contraseña son requeridos'
                ]);
            }
            
            $result = $this->model->loginUsuario($idUsuario, $password);
            
            if ($result['success']) {
                $_SESSION['user_id'] = $result['user']['ID_Usuario'];
                return json_encode([
                    'success' => true, 
                    'message' => 'Login exitoso',
                    'user_id' => $result['user']['ID_Usuario']
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
                    'user_id' => $userData['ID_Usuario']
                ]);
            }
        }
        return json_encode(['logged_in' => false]);
    }

}
?>