 -- Eliminar la base de datos si ya existe para empezar limpio
DROP DATABASE IF EXISTS DataAuditLabs_Tasks;

-- Crear y usar la base de datos
CREATE DATABASE DataAuditLabs_Tasks;
USE DataAuditLabs_Tasks;

-- ==========================================
-- 1. Tabla de Usuarios (Con campos de Login)
-- ==========================================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    token_recuperacion VARCHAR(100) NULL,
    rol ENUM('Coordinador', 'Desarrollador Frontend', 'Desarrollador Backend', 'DBA', 'Analista') NOT NULL,
    ultimo_login TIMESTAMP NULL DEFAULT NULL,
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- 2. Tabla de Proyectos
-- ==========================================
CREATE TABLE proyectos (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin_estimada DATE,
    estado ENUM('Planificacion', 'En Desarrollo', 'Pruebas', 'Completado') DEFAULT 'Planificacion'
);

-- ==========================================
-- 3. Tabla de Tareas (Actualizada con tus campos)
-- ==========================================
CREATE TABLE tareas (
    id_tarea INT AUTO_INCREMENT PRIMARY KEY,
    id_proyecto INT NOT NULL,
    id_usuario_asignado INT NULL, -- NULL si no tiene responsable asignado
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT, -- Campo agregado en tu modelo
    estado ENUM('Pendiente', 'En Progreso', 'Revisión', 'Testing', 'Completada') DEFAULT 'Pendiente',
    prioridad ENUM('Baja', 'Media', 'Alta', 'Urgente') DEFAULT 'Media',
    fecha_limite DATE, -- Campo agregado en tu modelo
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario_asignado) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

-- ==========================================
-- 4. Tabla de Comentarios (Bitácora de seguimiento)
-- ==========================================
CREATE TABLE comentarios (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    id_tarea INT NOT NULL,
    id_usuario INT NOT NULL,
    comentario TEXT NOT NULL,
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tarea) REFERENCES tareas(id_tarea) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- ==========================================
-- 5. Índices de Optimización
-- ==========================================
CREATE INDEX idx_tareas_estado ON tareas(estado);
CREATE INDEX idx_tareas_asignado ON tareas(id_usuario_asignado);

-- ==========================================
-- 6. Datos de Prueba Iniciales (Opcional)
-- ==========================================
INSERT INTO proyectos (nombre, descripcion, estado) 
VALUES ('Auditoría Interna', 'Revisión de logs y sistemas de seguridad', 'En Desarrollo');

INSERT INTO tareas (id_proyecto, titulo, descripcion, estado, prioridad, fecha_limite) 
VALUES (1, 'Configurar servidor web', 'Instalar Apache y PHP para el entorno de pruebas', 'Pendiente', 'Alta', '2026-06-15');
