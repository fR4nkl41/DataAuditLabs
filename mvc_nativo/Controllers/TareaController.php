<?php
// controllers/TareaController.php

// Requerir dependencias
require_once 'config/config.php';
require_once 'Models/TareaModel.php';
require_once 'Models/ProyectoModel.php';



class TareaController {
    
    private $db;
    private $tareaModel;
    private $proyectoModel;

    // 1. El Constructor inicializa la base de datos y el modelo
    public function __construct() {
        

    if (session_status() == PHP_SESSION_NONE) { session_start(); }
    if (!isset($_SESSION['id_usuario'])) {
    // Si no hay sesión, lo pateamos de vuelta al login
    header("Location: index.php?controller=auth&action=index");
    exit();
    }
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tareaModel = new Tarea($this->db);
        $this->proyectoModel = new Proyecto($this->db);
    }

    // 2. Acción para listar las tareas (Página principal del módulo)
    public function index() {
    $nombreUsuario = $_SESSION['nombre'];
    $id_usuario = $_SESSION['id_usuario'];
    $stmt = $this->tareaModel->obtenerTareasPorUsuario($id_usuario);
    $tareas = $stmt->fetchAll();
    require_once 'Views/tareas/lista_tareas.php';
    }

    public function create() {
        // Simplemente carga la vista del formulario
        $proyectoModel = new Proyecto($this->db);
        $stmt = $proyectoModel->leerTodos();
        $proyectos = $stmt->fetchAll();
        require_once 'Views/tareas/crear_tarea.php';
    }

  

    //Editar las tareas 
    public function edit()
    {
        if (isset($_GET['id'])) {
            $id_tarea = $_GET['id'];
            
            // Usamos la nueva función del modelo
            $tareaActual = $this->tareaModel->obtenerPorId($id_tarea);
            $proyectoModel = new Proyecto($this->db);
            $stmt = $proyectoModel->leerTodos();
            $proyectos = $stmt->fetchAll();
            
            // Si la consulta devolvió datos, cargamos la vista
            if ($tareaActual) {
                require_once 'Views/tareas/editar_tarea.php';
            } else {
                // Si el ID no existe en la BD, redirigimos
                header('Location: index.php?controller=tarea&action=index');
                exit();
            }
        } else {
            // Si no viene ningún ID en la URL, redirigimos
            header('Location: index.php?controller=tarea&action=index');
            exit();
        }
    }
        //Actualizar los datos del usuario
    public function actualizar()
    {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recibir los datos del formulario
            $id_tarea = $_POST['id'];
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $fecha_limite = $_POST['fecha_limite'];
            $estado = $_POST['estado'];
            $prioridad = $_POST['prioridad'];
            
            if ($this->tareaModel->editarTarea($id_tarea, $titulo, $descripcion, $fecha_limite,$estado,$prioridad)) {
                
                header('Location: index.php?controller=tarea&action=index&mensaje=actualizado');
                exit();
            } else {
                $error = "Hubo un error al actualizar la tarea.";
                require_once 'Views/tareas/editar_tarea.php';
            }
        }
    }
   // Procesamiento de formulario
   public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $id_proyecto = trim($_POST['id_proyecto'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $fecha_limite = trim($_POST['fecha_limite'] ?? '');
            $estado = $_POST['estado'] ?? 'Pendiente';
            $prioridad = $_POST['prioridad'] ?? 'Media';
            if (!empty($titulo) && !empty($id_proyecto)) {
                $this->tareaModel->setTitulo($titulo);
                $this->tareaModel->setProyecto($id_proyecto);
                $this->tareaModel->setDescripcion($descripcion);
                $this->tareaModel->setFechaLimite($fecha_limite);
                $this->tareaModel->setEstado($estado);
                $this->tareaModel->setPrioridad($prioridad);
                $this->tareaModel->setUsuarioAsignado($_SESSION['id_usuario']);
                
                if ($this->tareaModel->crear()) {
                    header("Location: index.php?controller=tarea&action=index&mensaje=creado");
                    exit();
                } else {
                    $error = "Hubo un problema al guardar la tarea en DataAuditLabs.";
                    require_once 'Views/tareas/crear_tarea.php';
                }
            } else {
                $error = "El título y el proyecto son obligatorios.";
                require_once 'Views/tareas/crear_tarea.php';
            }
        }
    }
    public function actualizarEstadoAjax() {
        header('Content-Type: application/json');

        // Verificamos que venga por POST y traiga los datos necesarios
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['estado'])) {
            
            $id_tarea = $_POST['id'];
            $estado = $_POST['estado'];

            if ($this->tareaModel->actualizarEstado($id_tarea, $estado)) {
                echo json_encode(['success' => true, 'mensaje' => 'Estado actualizado en la base de datos.']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar en la base de datos.']);
            }
            
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Datos incompletos.']);
        }
        exit();
    }

    public function actualizarPrioridadAjax() {
        header('Content-Type: application/json');

        // Verificamos que venga por POST y traiga los datos necesarios
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['prioridad'])) {
            
            $id_tarea = $_POST['id'];
            $prioridad = $_POST['prioridad'];

            if ($this->tareaModel->actualizarPrioridad($id_tarea, $prioridad)) {
                echo json_encode(['success' => true, 'mensaje' => 'Prioridad actualizado en la base de datos.']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar en la base de datos.']);
            }
            
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Datos incompletos.']);
        }
        exit();
    }

    // Nueva acción para eliminar mediante AJAX
    public function eliminarAjax() {
       
        header('Content-Type: application/json');

        if (isset($_GET['id'])) {
            $id_tarea = $_GET['id'];
            
 
            if ($this->tareaModel->eliminar($id_tarea)) {
                // Éxito: Devolvemos un JSON con success = true
                echo json_encode(['success' => true, 'mensaje' => 'Tarea eliminada correctamente.']);
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

    // 4. Acción para eliminar una tarea
    public function delete() {
        if (isset($_GET['id'])) {
            $id_tarea = $_GET['id'];
            
            // Metodo por eliminar por ID
            if ($this->tareaModel->eliminar($id_tarea)) {
                header("Location: index.php?controller=tarea&action=index&mensaje=eliminado");
                exit();
            }
        }
    }
}

?>