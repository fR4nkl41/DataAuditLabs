<?php
// Controllers/ProyectoController.php

require_once 'config/config.php';
require_once 'Models/ProyectoModel.php';

class ProyectoController {
    
    private $db;
    private $proyectoModel;

    public function __construct() {
        // Barrera de seguridad: Verificar sesión activa
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: index.php?controller=auth&action=index");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->proyectoModel = new Proyecto($this->db);
    }

    // Listar los proyectos
    public function index() {
        $stmt = $this->proyectoModel->leerTodos();
        $proyectos = $stmt->fetchAll();

        require_once 'Views/proyectos/lista_proyectos.php';
    }

    // Mostrar formulario de creación
    public function create() {
        require_once 'Views/proyectos/crear_proyecto.php';
    }

     public function delete() {
        if (isset($_GET['id'])) {
            $id_proyecto = $_GET['id'];
            
            // Metodo por eliminar por ID
            if ($this->proyectoModel->eliminar($id_proyecto)) {
                header("Location: index.php?controller=proyecto&action=index&mensaje=eliminado");
                exit();
            }
        }
    }

    // Procesar la creación (POST)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            
            // Si la fecha viene vacía en el HTML, mandamos NULL a la BD
            $fecha_inicio = !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
            $fecha_fin_estimada = !empty($_POST['fecha_fin_estimada']) ? $_POST['fecha_fin_estimada'] : null;
            
            $estado = $_POST['estado'] ?? 'Planificacion';

            // Validación básica (el nombre es lo único estrictamente obligatorio)
            if (!empty($nombre)) {
                
                $this->proyectoModel->setNombre($nombre);
                $this->proyectoModel->setDescripcion($descripcion);
                $this->proyectoModel->setFechaInicio($fecha_inicio);
                $this->proyectoModel->setFechaFinEstimada($fecha_fin_estimada);
                $this->proyectoModel->setEstado($estado);
                
                if ($this->proyectoModel->crear()) {
                    header("Location: index.php?controller=proyecto&action=index&mensaje=proyecto_creado");
                    exit();
                } else {
                    $error = "Hubo un problema al guardar el proyecto en la base de datos.";
                    require_once 'Views/proyectos/crear_proyecto.php';
                }
            } else {
                $error = "El nombre del proyecto es obligatorio.";
                require_once 'Views/proyectos/crear_proyecto.php';
            }
        }
    }
    public function edit() {
        if (isset($_GET['id'])) {
            $id_proyecto = $_GET['id'];
            
            // Asumiendo que creaste un método obtenerPorId($id) en ProyectoModel
            $proyectoActual = $this->proyectoModel->obtenerPorId($id_proyecto);
            
            if ($proyectoActual) {
                require_once 'Views/proyectos/editar_proyecto.php';
            } else {
                header('Location: index.php?controller=proyecto&action=index');
                exit();
            }
        } else {
            header('Location: index.php?controller=proyecto&action=index');
            exit();
        }
    }

     public function actualizarEstadoAjax() {
        header('Content-Type: application/json');

        // Verificamos que venga por POST y traiga los datos necesarios
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['estado'])) {
            
            $id_proyecto = $_POST['id'];
            $estado = $_POST['estado'];

            if ($this->proyectoModel->actualizarEstado($id_proyecto, $estado)) {
                echo json_encode(['success' => true, 'mensaje' => 'Estado actualizado en la base de datos.']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar en la base de datos.']);
            }
            
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Datos incompletos.']);
        }
        exit();
    }

    public function eliminarAjax() {
       
        header('Content-Type: application/json');

        if (isset($_GET['id'])) {
            $id_proyecto = $_GET['id'];
            
 
            if ($this->proyectoModel->eliminar($id_proyecto)) {
                // Éxito: Devolvemos un JSON con success = true
                echo json_encode(['success' => true, 'mensaje' => 'El proyecto eliminada correctamente.']);
            } else {
                // Error en la BD
                echo json_encode(['success' => false, 'mensaje' => 'No se pudo eliminar la tarea.']);
            }
        } else {
            // Faltó el ID
            echo json_encode(['success' => false, 'mensaje' => 'ID no proporcionado.']);
        }
        
        // Es vital usar exit() para que no se imprima nada más de código HTML
        exit();
    }

  public function actualizar()
    {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recibir los datos del formulario
            $id_proyecto = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin_estimada = $_POST['fecha_fin_estimada'];
            $estado = $_POST['estado'];

            if ($this->proyectoModel->editarProyecto($id_proyecto, $nombre, $descripcion, $fecha_inicio,$fecha_fin_estimada,$estado)) {
                
                header('Location: index.php?controller=proyecto&action=index&mensaje=actualizado');
                exit();
            } else {
                $error = "Hubo un error al actualizar la Proyecto.";
                require_once 'Views/proyectos/editar_proyecto.php';
            }
        }
    }
}
?>