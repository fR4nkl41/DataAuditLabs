<?php
class usuario{
    //Conexion con base de datos
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // 1. Buscar usuario por correo
    public function obtenerPorEmail($email) {
        // Buscamos solo usuarios activos (activo = 1)
        $query = "SELECT * FROM usuarios WHERE email = :email AND activo = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Retornamos el array asociativo con los datos del usuario (o false si no existe)
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function registrarAcceso($id_usuario) {
        $query = "UPDATE usuarios SET ultimo_login = CURRENT_TIMESTAMP WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_usuario', $id_usuario);
        return $stmt->execute();
    }

    // Método para registrar un nuevo usuario
    public function registrar($nombre, $email, $password_hash, $rol) {
        // Por defecto, lo creamos como activo (1)
        $query = "INSERT INTO usuarios (nombre, email, password_hash, rol, activo) 
                  VALUES (:nombre, :email, :password_hash, :rol, 1)";
                  
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':rol', $rol);
        
        try {
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Si el correo ya existe, PDO lanzará una excepción por el UNIQUE
            return false;
        }
    }


}
?>