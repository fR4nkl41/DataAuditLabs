<?php
// controllers/TareaController.php

// Requerir dependencias
require_once 'config/config.php';
require_once 'Models/TareaModel.php';



class TareaController {
    
    private $db;
    private $tareaModel;

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
        require_once 'Views/tareas/crear_tarea.php';
    }

  

    //Editar las tareas 
    public function edit()
    {
        if (isset($_GET['id'])) {
            $id_tarea = $_GET['id'];
            
            // Usamos la nueva función del modelo
            $tareaActual = $this->tareaModel->obtenerPorId($id_tarea);
            
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
         
            
            if ($this->tareaModel->editarTarea($id_tarea, $titulo, $descripcion, $fecha_limite)) {
                
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
            
            if (!empty($titulo) && !empty($id_proyecto)) {
                $this->tareaModel->setTitulo($titulo);
                $this->tareaModel->setProyecto($id_proyecto);
                $this->tareaModel->setDescripcion($descripcion);
                $this->tareaModel->setFechaLimite($fecha_limite);
                
               
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