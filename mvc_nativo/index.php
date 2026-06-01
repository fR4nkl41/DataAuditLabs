<?php
// index.php (Raíz del proyecto)

// 1. Obtener el controlador y la acción de la URL (Por defecto será 'tarea' y 'index')
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'tarea';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';


$controllerFile = "Controllers/" . ucfirst($controllerName) . "Controller.php";

// 3. Verificar si el archivo existe y cargarlo
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    $controllerClass = ucfirst($controllerName) . "Controller";
    
    // Instanciar el controlador (Ej: $controller = new TareaController();)
    $controller = new $controllerClass();
    
    // 4. Verificar si el método (acción) existe dentro del controlador
    if (method_exists($controller, $actionName)) {
        // Ejecutar la acción (Ej: $controller->index();)
        $controller->$actionName();
    } else {
        echo "<h1>Error 404</h1><p>La acción '$actionName' no existe en $controllerClass.</p>";
    }
} else {
    echo "<h1>Error 404</h1><p>El controlador '$controllerName' no fue encontrado.</p>";
}
?>