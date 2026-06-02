<?php
class Tarea {
    // 1. Conexión a la base de datos
    private $conn;

    // Propiedades del modelo (Mapeo de la tabla)
    private $id_tarea;
    private $id_proyecto;
    private $id_usuario_asignado;
    private $titulo;
    private $estado;
<<<<<<< HEAD
=======
    private $prioridad;
>>>>>>> mergeprueba
    private $descripcion;
    private $fecha_limite;

    // 2. Constructor: Recibe la conexión a la BD
    public function __construct($db) {
        $this->conn = $db;
    }

    public function setIdTarea($id_tarea) {$this->id_tarea = $id_tarea;}
    public function setTitulo($titulo) { $this->titulo = $titulo; }
<<<<<<< HEAD
    public function setProyecto($id_proyecto) { $this->id_proyecto = $id_proyecto; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setFechaLimite($fecha_limite) { $this->fecha_limite = $fecha_limite; }

    // 3. Métodos CRUD (Ejemplo: Crear una tarea)
    public function crear() {
        $query = "INSERT INTO tareas (id_proyecto, titulo,estado,descripcion,fecha_limite) 
                  VALUES (:id_proyecto, :titulo, 'Pendiente',:descripcion,:fecha_limite)";
                  
=======
    public function setPrioridad($prioridad){$this->prioridad = $prioridad;}
    public function setEstado($estado){$this->estado = $estado;}
    public function setProyecto($id_proyecto) { $this->id_proyecto = $id_proyecto; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setFechaLimite($fecha_limite) { $this->fecha_limite = $fecha_limite; }
    public function setUsuarioAsignado($id_usuario) { $this->id_usuario_asignado = $id_usuario; }

    // 3. Métodos CRUD (Ejemplo: Crear una tarea)
    public function crear() {
        $query = "INSERT INTO tareas (id_proyecto, id_usuario_asignado, titulo, descripcion, estado, prioridad, fecha_limite) VALUES (:id_proyecto, :id_usuario_asignado, :titulo, :descripcion, :estado, :prioridad, :fecha_limite)";

>>>>>>> mergeprueba
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos y enlazar parámetros (Seguridad contra inyección SQL)
        $stmt->bindParam(':id_proyecto', $this->id_proyecto);
<<<<<<< HEAD
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descripcion', $this->descripcion);
=======
        $stmt->bindParam(':id_usuario_asignado', $this->id_usuario_asignado);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':prioridad', $this->prioridad);
>>>>>>> mergeprueba
        $stmt->bindParam(':fecha_limite', $this->fecha_limite);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function obtenerPorId($id_tarea)
    {
        $query = "SELECT * FROM tareas WHERE id_tarea = :id_tarea LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_tarea', $id_tarea);
        $stmt->execute();
        
<<<<<<< HEAD
        // Retornamos el array asociativo con los datos de la tarea
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

      public function editarTarea($id_tarea, $titulo, $descripcion, $fecha_limite)
    {
        $query = "UPDATE tareas set titulo = :titulo, descripcion = :descripcion, fecha_limite = :fecha_limite WHERE id_tarea = :id_tarea";
        $stmt = $this -> conn->prepare($query);

        $stmt->bindParam(':id_tarea',$id_tarea);
        $stmt->bindParam(':titulo',$titulo);
        $stmt->bindParam(':descripcion',$descripcion);
        $stmt->bindParam(':fecha_limite',$fecha_limite);

        return $stmt->execute();
    }
    
=======
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarTarea($id_tarea, $titulo, $descripcion, $fecha_limite, $estado, $prioridad)
    {
        $query = "UPDATE tareas 
                  SET titulo = :titulo, descripcion = :descripcion, fecha_limite = :fecha_limite, 
                      estado = :estado, prioridad = :prioridad 
                  WHERE id_tarea = :id_tarea";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_tarea', $id_tarea);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_limite', $fecha_limite);
        
        // Ahora sí existen estas variables
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':prioridad', $prioridad);

        return $stmt->execute();
    }
>>>>>>> mergeprueba

    public function leerTodos()
    {
        $query = "SELECT * FROM tareas";
        $stmt = $this->conn->prepare($query);

         $stmt->execute();
         return $stmt;
    }

    public function eliminar($id_tarea)
    {
        $query = "DELETE FROM tareas where id_tarea = :id_tarea";
        $stmt = $this->conn->prepare($query);

        $stmt -> bindParam(':id_tarea', $id_tarea);

        try {
<<<<<<< HEAD
            // Evaluamos si la ejecución fue exitosa
=======
          
>>>>>>> mergeprueba
            if ($stmt->execute()) {
                return true; 
            }
            return false;
        } catch (PDOException $e) {
            return false; 
        }
    }
<<<<<<< HEAD

    // 4. Lógica de Negocio (Ejemplo: Obtener tareas de un usuario específico)
    public function obtenerTareasPorUsuario($id_usuario) {
        $query = "SELECT t.titulo, t.estado, p.nombre as proyecto 
=======
    public function actualizarEstado($id_tarea, $estado) {
        $query = "UPDATE tareas SET estado = :estado WHERE id_tarea = :id_tarea";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_tarea', $id_tarea);
        
        return $stmt->execute();
    }
    public function actualizarPrioridad($id_tarea, $prioridad) {
        $query = "UPDATE tareas SET prioridad = :prioridad WHERE id_tarea = :id_tarea";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':prioridad', $prioridad);
        $stmt->bindParam(':id_tarea', $id_tarea);
        
        return $stmt->execute();
    }
    public function actualizarProyecto($id_tarea, $id_proyecto) {
        $query = "UPDATE tareas SET id_proyecto = :id_proyecto WHERE id_tarea = :id_tarea";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_proyecto', $id_proyecto);
        $stmt->bindParam(':id_tarea', $id_tarea);
        
        return $stmt->execute();
    }
    //Funcion para a futuro cuando manejemos secciones de usuario
    public function obtenerTareasPorUsuario($id_usuario) {
        $query = "SELECT t.*, p.nombre as proyecto 
>>>>>>> mergeprueba
                  FROM tareas t
                  INNER JOIN proyectos p ON t.id_proyecto = p.id_proyecto
                  WHERE t.id_usuario_asignado = :id_usuario";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        
<<<<<<< HEAD
        return $stmt; // El Controlador se encargará de procesar este resultado
=======
        return $stmt; 
>>>>>>> mergeprueba
    }
}
?>