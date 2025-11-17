# Proyecto Final Backend

## Descripción
Este es el backend del proyecto final de año en base a la empresa Berrutti Turismo, el mismo esta desarrollado en PHP que incluye funcionalidades de gestión de usuarios y está preparado para manejar operaciones relacionadas con un sistema de transporte (ómnibus, boletos, pagos, etc.). El proyecto está estructurado siguiendo el patrón MVC (Modelo-Vista-Controlador) y utiliza una base de datos MySQL para almacenar la información.

## Características Principales
- **Registro de Usuarios**: Permite crear nuevas cuentas con validación de datos (nombre completo, documento, correo o teléfono, contraseña).
- **Login y Autenticación**: Verifica credenciales y maneja sesiones mediante tokens almacenados en cookies.
- **Logout**: Cierra la sesión del usuario invalidando el token.
- **Obtener Datos de Usuario**: Recupera información del usuario autenticado mediante token.
- **Preparado para Gestión de Boletos**: Funcionalidades para registrar y obtener boletos (comentadas actualmente).
- **Preparado para Gestión de Pagos**: Operaciones para registrar, obtener y actualizar estados de pagos (comentadas).
- **Preparado para Gestión de Ómnibus**: Funcionalidades para registrar, obtener, actualizar ubicación y listar ómnibus (comentadas).
- **Preparado para Gestión de Choferes**: Operaciones para registrar y obtener choferes (comentadas).
- **Preparado para Gestión de Rutas**: Funcionalidades para registrar y obtener rutas (comentadas).
- **Preparado para Gestión de Servicios**: Operaciones para registrar, obtener y listar servicios por usuario (comentadas).
- **Preparado para Gestión de Encomiendas**: Funcionalidades para registrar, obtener y listar encomiendas por ómnibus (comentadas).
- **Conexión Segura a BD**: Utiliza __prepared statements__ para prevenir inyecciones SQL.
- **Autenticación por Tokens**: Usa tokens de sesión almacenados en cookies HTTP-only para mayor seguridad.

## Estructura del Proyecto
El código está organizado en la carpeta `src/` con los siguientes componentes:

### `src/http.php`
- Actúa como el punto de entrada principal de la API REST.
- Maneja CORS (Cross-Origin Resource Sharing) permitiendo orígenes específicos.
- Inicializa los controladores disponibles.
- Enruta las solicitudes basándose en el parámetro GET `action` hacia los métodos correspondientes de los controladores.
- Actualmente solo las acciones de usuario están activas; las demás están comentadas para futuras implementaciones.
- Responde con JSON para todas las operaciones.

### Controladores en `src/controller/`
Los controladores manejan la lógica de negocio, validan entradas y coordinan con los modelos.

#### `UsuarioController.php`
- Controlador que maneja las operaciones relacionadas con usuarios.
- Métodos disponibles:
  - `registrar()`: Registra un nuevo usuario con validación de datos (POST, JSON).
  - `login()`: Autentica al usuario y genera un token de sesión (POST, JSON).
  - `logout()`: Invalida el token de sesión actual (POST, JSON).
  - `obtenerDatosUsuario()`: Obtiene información del usuario por token (POST, JSON).
  - Métodos comentados: `verificarSesion()`, `actualizarContraseña()`, `actualizarTelefono()`.

#### `BoletoController.php`
- Controlador para gestión de boletos (comentado en http.php).
- Métodos preparados: `registrar()`, `obtener()`.

#### `ChoferController.php`
- Controlador para gestión de choferes (comentado en http.php).
- Métodos preparados: `registrar()`, `obtener()`.

#### `EncomiendaController.php`
- Controlador para gestión de encomiendas (comentado en http.php).
- Métodos preparados: `registrar()`, `obtener()`, `listarPorOmnibus()`.

#### `OmnibusController.php`
- Controlador para gestión de ómnibus (comentado en http.php).
- Métodos preparados: `registrar()`, `obtener()`, `actualizarUbicacion()`, `listar()`.

#### `PagoController.php`
- Controlador para gestión de pagos (comentado en http.php).
- Métodos preparados: `registrar()`, `obtener()`, `actualizarEstado()`, `obtenerPorUsuario()`.

#### `RutaController.php`
- Controlador para gestión de rutas (comentado en http.php).
- Métodos preparados: `registrar()`, `obtener()`.

#### `ServicioController.php`
- Controlador para gestión de servicios (comentado en http.php).
- Métodos preparados: `registrar()`, `obtener()`, `obtenerPorUsuario()`.

### Modelos en `src/modelo/`
Los modelos interactúan directamente con la base de datos utilizando prepared statements.

#### `UsuarioModel.php`
- Modelo que interactúa con la tabla `usuario` en la base de datos.
- Métodos disponibles:
  - `registrarUsuario()`: Inserta un nuevo usuario con contraseña hasheada y genera token.
  - `loginUsuario()`: Verifica credenciales y actualiza token de sesión.
  - `cerrarSesion()`: Invalida el token en la BD.
  - `obtenerUsuarioPorToken()`: Obtiene datos del usuario por token.
  - Métodos comentados: `actualizarContraseña()`, `actualizarTelefono()`.

#### Otros Modelos
- `BoletoModel.php`, `ChoferModel.php`, `EncomiendaModel.php`, `OmnibusModel.php`, `PagoModel.php`, `RutaModel.php`, `ServicioModel.php`: Modelos preparados para futuras implementaciones, siguiendo el mismo patrón de prepared statements y manejo seguro de BD.

### `src/modelo/Conexion.php`
- Contiene la función `connection()` que establece la conexión con la base de datos MySQL.
- Configuración:
  - Host: localhost
  - Base de datos: bd_proyectofinal
  - Usuario: root
  - Contraseña: (vacía)
  - Puerto: 3306

## Instalación y Configuración
1. **Instalar Dependencias**: Ejecutar `composer install` para instalar las librerías necesarias (si aplica).
2. **Base de Datos**: Importar el archivo `bd_proyectofinal.sql` en MySQL para crear la estructura de la base de datos.
3. **Configuración**: Asegurarse de que el servidor MySQL esté corriendo y accesible con las credenciales especificadas en `Conexion.php`.

## Uso
- **Iniciar el Servidor API**: Ejecutar `php src/http.php` desde la raíz del proyecto o configurarlo en un servidor web como Apache/Nginx.
- **API de Usuarios**: Las solicitudes se hacen vía POST con datos en formato JSON. Usar el parámetro `action` en la URL (ej: `?action=registrar`).
- **Autenticación**: Se utilizan tokens de sesión almacenados en cookies HTTP-only para mantener la autenticación.

## Puertos Utilizados
- **Servidor HTTP/API**: Corre en el puerto configurado en el servidor web (por ejemplo, Apache en 80/443) o usando `php -S localhost:8000 src/http.php` para desarrollo.

## Tecnologías Utilizadas
- **PHP**: Lenguaje principal del backend.
- **MySQL**: Sistema de gestión de base de datos.
- **Composer**: Gestor de dependencias para PHP (si se usan librerías externas).

## Notas de Seguridad
- Las contraseñas se almacenan hasheadas usando `password_hash()`.
- Se utilizan _prepared statements_ para todas las consultas a la base de datos.
- La validación de entrada se realiza en el controlador antes de procesar los datos.
- Los tokens de sesión se generan aleatoriamente y se almacenan en cookies HTTP-only con SameSite=Strict.

## Archivos Adicionales
- `composer.json` y `composer.lock`: Configuración de dependencias.
- `Log.php`: Sistema de logging (requerido para operaciones).
- `errors.log`: Archivo de registro de errores.
- `.gitignore`: Archivos ignorados por Git.
