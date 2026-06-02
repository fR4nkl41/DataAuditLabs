<?php
// Controllers/AuthController.php

require_once 'config/config.php';
require_once 'Models/UsuarioModel.php';

class AuthController {
    
    private $db;
    private $usuarioModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this-> usuarioModel = new usuario($this->db);
        
        // Arrancar la sesión de PHP si aún no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // 1. Mostrar el formulario de Login
    public function index() {
        
        if (isset($_SESSION['id_usuario'])) {
            header("Location: index.php?controller=tarea&action=index");
            exit();
        }
        
        
        require_once 'Views/auth/login.php';
    }

    public function registro() {
        require_once 'Views/auth/registro.php';
    }

    // Procesar el formulario de registro
    public function storeRegistro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Recibir y limpiar datos
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $rol = $_POST['rol'] ?? 'Analista'; // Analista por defecto si no viene
            
            if (!empty($nombre) && !empty($email) && !empty($password)) {
                
                // ¡LA PARTE MÁS IMPORTANTE! Encriptar la contraseña
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Guardar en la base de datos
                if ($this->usuarioModel->registrar($nombre, $email, $password_hash, $rol)) {
                    // Redirigir al login con mensaje de éxito
                    header("Location: index.php?controller=auth&action=index&mensaje=registrado");
                    exit();
                } else {
                    $error = "No se pudo registrar el usuario. Es posible que el correo ya esté en uso.";
                    require_once 'Views/auth/registro.php';
                }
            } else {
                $error = "Todos los campos (Nombre, Correo y Contraseña) son obligatorios.";
                require_once 'Views/auth/registro.php';
            }
        }
    }

    // 2. Procesar los datos del formulario (POST)
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (!empty($email) && !empty($password)) {
                
                // Pedimos al modelo que busque el correo
                $usuario = $this->usuarioModel->obtenerPorEmail($email);
                
                // Si el usuario existe y la contraseña escrita coincide con el hash de la BD...
                if ($usuario && password_verify($password, $usuario['password_hash'])) {
                    
                    // ¡Éxito! Creamos las variables de sesión
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['rol'] = $usuario['rol'];
                    
                    // Registramos la hora a la que entró
                    $this->usuarioModel->registrarAcceso($usuario['id_usuario']);
                    
                    // Lo enviamos al módulo de tareas
                    header("Location: index.php?controller=tarea&action=index");
                    exit();
                    
                } else {
                    $error = "El correo o la contraseña son incorrectos (o la cuenta está inactiva).";
                    require_once 'Views/auth/login.php';
                }
                
            } else {
                $error = "Por favor, ingresa tu correo y contraseña.";
                require_once 'Views/auth/login.php';
            }
        }
    }

    // 3. Cerrar sesión
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Destruir todas las variables de sesión
        session_unset();
        session_destroy();
        
        // Redirigir al formulario de login
        header("Location: index.php?controller=auth&action=index");
        exit();
    }
}
?>