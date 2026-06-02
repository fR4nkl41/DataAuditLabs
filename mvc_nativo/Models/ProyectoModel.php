<?php
// Models/ProyectoModel.php

class Proyecto {
    private $conn;

    // Propiedades mapeadas a la tabla 'proyectos'
    private $id_proyecto;
    private $nombre;
    private $descripcion;
    private $fecha_inicio;
    private $fecha_fin_estimada;
    private $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Setters
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setFechaInicio($fecha_inicio) { $this->fecha_inicio = $fecha_inicio; }
    public function setFechaFinEstimada($fecha_fin_estimada) { $this->fecha_fin_estimada = $fecha_fin_estimada; }
    public function setEstado($estado) { $this->estado = $estado; }

    // Método para crear un nuevo proyecto
    public function crear() {
        $query = "INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_fin_estimada, estado) 
                  VALUES (:nombre, :descripcion, :fecha_inicio, :fecha_fin_estimada, :estado)";
                  
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':fecha_inicio', $this->fecha_inicio);
        $stmt->bindParam(':fecha_fin_estimada', $this->fecha_fin_estimada);
        $stmt->bindParam(':estado', $this->estado);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    //Actualizar estado del proyecto con ajax
    public function actualizarEstado($id_proyecto, $estado) {
        $query = "UPDATE proyectos SET estado = :estado WHERE id_proyecto = :id_proyecto";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_proyecto', $id_proyecto);
        
        return $stmt->execute();
    }

    // Método para listar todos los proyectos (Útil para llenar el combobox en las tareas)
    public function leerTodos() {
        $query = "SELECT * FROM proyectos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    public function obtenerPorId($id_proyecto) {
        $query = "SELECT * FROM proyectos WHERE id_proyecto = :id_proyecto LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_proyecto', $id_proyecto);
        $stmt->execute();
        
        // Retornamos el array asociativo con los datos del proyecto
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
     public function eliminar($id_proyecto)
    {
        $query = "DELETE FROM proyectos where id_proyecto = :id_proyecto";
        $stmt = $this->conn->prepare($query);

        $stmt -> bindParam(':id_proyecto', $id_proyecto);

        try {
          
            if ($stmt->execute()) {
                return true; 
            }
            return false;
        } catch (PDOException $e) {
            return false; 
        }
    }


     public function editarProyecto($id_proyecto, $nombre, $descripcion, $fecha_inicio,$fecha_fin_estimada,$estado)
    {
        $query = "UPDATE proyectos 
                  SET nombre = :nombre, descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_fin_estimada = :fecha_fin_estimada, 
                      estado = :estado
                  WHERE id_proyecto = :id_proyecto";
        $stmt = $this -> conn->prepare($query);

        $stmt->bindParam(':id_proyecto',$id_proyecto);
        $stmt->bindParam(':nombre',$nombre);
        $stmt->bindParam(':descripcion',$descripcion);
        $stmt->bindParam(':fecha_inicio',$fecha_inicio);
        $stmt->bindParam(':fecha_fin_estimada',$fecha_fin_estimada);
        $stmt->bindParam(':estado',$estado);

        return $stmt->execute();
    }
}


?>