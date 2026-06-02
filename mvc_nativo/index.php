<?php
// index.php (Raíz del proyecto)

// 0. Iniciar el manejo de sesiones globalmente para toda la aplicación
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// 1. Definir el controlador por defecto de forma inteligente
// Si el usuario ya está logueado, lo mandamos a 'tarea'. Si no, al login ('auth').
$defaultController = isset($_SESSION['id_usuario']) ? 'tarea' : 'auth';
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : $defaultController;
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// 3. Construir la ruta exacta del archivo (Respetando mayúsculas)
$controllerClass = ucfirst($controllerName) . "Controller";
$controllerFile = "Controllers/" . $controllerClass . ".php";

if (file_exists($controllerFile)) {
    
    require_once $controllerFile;
    
    if (class_exists($controllerClass)) {
        
        $controller = new $controllerClass();
        
        if (method_exists($controller, $actionName)) {
            // Ejecutar la acción
            $controller->$actionName();
        } else {
            echo "<h1>Error 404</h1><p>La acción '<b>$actionName</b>' no existe en el controlador.</p>";
        }
    } else {
         echo "<h1>Error 500</h1><p>El archivo existe, pero la clase '<b>$controllerClass</b>' no fue encontrada.</p>";
    }
} else {
    echo "<h1>Error 404</h1><p>El controlador no fue encontrado. El sistema intentó buscar en la ruta: <b>$controllerFile</b></p>";
}
?>