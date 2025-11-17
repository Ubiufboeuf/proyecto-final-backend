<?php
require_once __DIR__ . '/../modelo/UsuarioModel.php';

class UsuarioController {
    private $model;
    
    public function __construct() {
        $this->model = new UsuarioModel();
    }
    
    public function registrar() {
        // header('Content-Type: application/json'); // <- cabecera para mandar al cliente
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json_data = file_get_contents("php://input");
            $user_data = json_decode($json_data, true); // Devuelve un array asociativo

            $nombre_completo = $user_data['fullname'] ?? '';
            $documento = $user_data['document'] ?? '';
            $correo = $user_data['email'] ?? '';
            $telefono = $user_data['phone'] ?? '';
            $contrasenia = $user_data['password'] ?? '';
            $contacto = $user_data['contact'] ?? '';

            if (($contacto == 'email' && empty($correo)) && ($contacto == 'phone' && empty($telefono))) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar un contacto (correo o teléfono)'
                ]);
            }
            
            if ($contacto == 'email' && empty($correo)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar el correo'
                ]);
            }

            if ($contacto == 'phone' && empty($telefono)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar el teléfono'
                ]);
            }

            if (empty($nombre_completo)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar el nombre completo (nombre apellido)'
                ]);
            }

            if (empty($documento)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar el documento (cédula o dni)'
                ]);
            }

            if (empty($contrasenia)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar la contraseña'
                ]);
            }

            // Validar formato de correo
            if ($contacto == 'email' && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'El correo no es válido'
                ]);
            }
            
            // Validar que la contraseña tenga mínimo 6 caracteres
            if (strlen($contrasenia) < 6) {
                return json_encode([
                    'success' => false, 
                    'message' => 'La contraseña debe tener al menos 6 caracteres'
                ]);
            }
            
            $result = $this->model->registrarUsuario($nombre_completo, $documento, $contrasenia, $user_data[$contacto], $contacto);
            if ($result['success']) {
                setcookie(
                    "berrutti-web-auth-token",
                    $result['token'],
                    [
                        "expires" => time() + (60 * 60 * 24 * 7), // 7 días
                        "path" => "/",
                        "httponly" => true,
                        "secure" => false, // cambiar cuando la use la web en producción
                        "samesite" => "Strict"
                    ]
                );
            }

            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json_data = file_get_contents("php://input");
            $user_data = json_decode($json_data, true); // Devuelve un array asociativo

            $correo = $user_data['email'] ?? '';
            $telefono = $user_data['phone'] ?? '';
            $contrasenia = $user_data['password'] ?? '';
            $tipoContacto = $user_data['contact'] ?? '';
            $contacto = $user_data[$tipoContacto];

            if (($tipoContacto == 'email' && empty($correo)) && ($tipoContacto == 'phone' && empty($telefono))) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar un contacto (correo o teléfono)'
                ]);
            }

            if ($tipoContacto == 'email' && empty($correo)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar el correo'
                ]);
            }

            if ($tipoContacto == 'phone' && empty($telefono)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar el teléfono'
                ]);
            }

            if (empty($contrasenia)) {
                return json_encode([
                    'success' => false,
                    'message' => 'Falta especificar la contraseña'
                ]);
            }

            // Validar formato de correo
            if ($tipoContacto == 'email' && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                return json_encode([
                    'success' => false, 
                    'message' => 'El correo no es válido'
                ]);
            }

            // Validar que la contraseña tenga mínimo 6 caracteres
            if (strlen($contrasenia) < 6) {
                return json_encode([
                    'success' => false, 
                    'message' => 'La contraseña debe tener al menos 6 caracteres'
                ]);
            }
            
            $result = $this->model->loginUsuario($contacto, $tipoContacto, $contrasenia);
            if ($result['success']) {
                setcookie(
                    "berrutti-web-auth-token",
                    $result['token'],
                    [
                        "expires" => time() + (60 * 60 * 24 * 7), // 7 días
                        "path" => "/",
                        "httponly" => true,
                        "secure" => false, // cambiar cuando la use la web en producción
                        "samesite" => "Strict"
                    ]
                );
            }

            return json_encode($result);
        }
        return json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    
    public function logout() {
        // Orden:
        // 1. comprobar si el usuario tiene una cookie de sesión
        // 3. actualizar la bd - primero actualizar la fuente de la verdad
        // 2. invalidar la cookie - después tratar la experiencia de usuario

        // comprobar la cookie
        $token = $_COOKIE['berrutti-web-auth-token'] ?? null;

        if (!$token) {
            return json_encode(['success' => false, 'message' => 'No tienes una sesión activa']);
        }

        // actualizar bd
        $result = $this->model->cerrarSesion($token);

        if (!$result['success']) {
            return json_encode(['success' => false, 'message' => 'Error interno. Error en la BD al cerrar sesión. Por favor, contacta al soporte']);
        }
        
        // invalidar la cookie
        setcookie(
            "berrutti-web-auth-token",
            $token,
            [
                "expires" => 1, // forzar expiración de cookie para que el navegador la elimine
                "path" => "/",
                "httponly" => true,
                "secure" => false, // cambiar cuando la use la web en producción
                "samesite" => "Strict"
            ]
        );
        
        return json_encode(['success' => true, 'message' => 'Sesión cerrada']);
    }

    // public function actualizarContraseña() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         if (!isset($_SESSION['user_id'])) {
    //             return json_encode([
    //                 'success' => false, 
    //                 'message' => 'Usuario no autenticado'
    //             ]);
    //         }

    //         $nuevaContrasenia = $_POST['nueva_contrasenia'] ?? '';
            
    //         if (empty($nuevaContrasenia)) {
    //             return json_encode([
    //                 'success' => false, 
    //                 'message' => 'Nueva contraseña es requerida'
    //             ]);
    //         }
            
    //         if (strlen($nuevaContrasenia) < 6) {
    //             return json_encode([
    //                 'success' => false, 
    //                 'message' => 'La contraseña debe tener al menos 6 caracteres'
    //             ]);
    //         }
            
    //         $result = $this->model->actualizarContraseña($_SESSION['user_id'], $nuevaContrasenia);
    //         return json_encode($result);
    //     }
    //     return json_encode(['success' => false, 'message' => 'Método no permitido']);
    // }

    // public function actualizarTelefono() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         if (!isset($_SESSION['user_id'])) {
    //             return json_encode([
    //                 'success' => false, 
    //                 'message' => 'Usuario no autenticado'
    //             ]);
    //         }

    //         $telefono = $_POST['telefono'] ?? '';
            
    //         if (empty($telefono) || !is_numeric($telefono)) {
    //             return json_encode([
    //                 'success' => false, 
    //                 'message' => 'Teléfono válido es requerido'
    //             ]);
    //         }
            
    //         $result = $this->model->actualizarTelefono($_SESSION['user_id'], $telefono);
    //         return json_encode($result);
    //     }
    //     return json_encode(['success' => false, 'message' => 'Método no permitido']);
    // }
}

?>