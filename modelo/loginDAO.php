
<?php
require_once  'conexion.php';


class login
{
    function login($username, $password)
    {
        $connection = connection();

        // Consulta para obtener el hash de la contraseña del usuario
        $sql = "SELECT * FROM usuario WHERE usuario = '$username'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // Obtener el hash de la contraseña del resultado
            $row = $result->fetch_assoc();
            $stored_hash = $row['password_hash'];

            // Verificar la contraseña
            if (password_verify($password, $stored_hash)) {
                // La contraseña es correcta
                echo "Inicio de sesión exitoso.";
                // Aquí podrías iniciar la sesión del usuario y redirigirlo a su panel
            } else {
                // La contraseña es incorrecta
                echo "Usuario o contraseña incorrectos.";
            }
        } else {
            // El nombre de usuario no existe
            echo "Usuario o contraseña incorrectos.";
        }

        // Cerrar conexión
        $connection->close();
    }
}
?>