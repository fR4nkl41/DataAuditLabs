<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tareas - DataAuditLabs</title>
</head>
<body>

    <h1>Gestión de Tareas</h1>

    <!-- 1. Mostrar mensajes de retroalimentación (Vienen de la redirección del Controlador) -->
    <?php if (isset($_GET['mensaje'])): ?>
        <div>
            <?php if ($_GET['mensaje'] == 'creado'): ?>
                <p><strong>Éxito:</strong> La tarea se creó correctamente.</p>
            <?php elseif ($_GET['mensaje'] == 'eliminado'): ?>
                <p><strong>Éxito:</strong> La tarea fue eliminada.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- 2. Botón/Enlace para crear una nueva tarea -->
    <!-- Nota cómo la URL apunta al index, especificando el controlador y la acción -->
    <p>
        <a href="index.php?controller=tarea&action=create">Crear Nueva Tarea</a>
    </p>

    <!-- 3. Estructura de la Tabla de Datos -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>ID Proyecto</th>
                <th>Estado</th>
                <th>prioridad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- 4. Validar si hay tareas y recorrer el array enviado por el Controlador -->
            <?php if (!empty($tareas)): ?>
                <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?php echo $tarea['id_tarea']; ?></td>
                        <td><?php echo htmlspecialchars($tarea['titulo']); ?></td>
                        <td><?php echo $tarea['id_proyecto']; ?></td>
                        <td><?php echo $tarea['estado']; ?></td>
                        <td><?php echo $tarea['prioridad']; ?></td>
                        
                        <!-- 5. Enlaces de Acción (Pasando el ID por GET) -->
                        <td>
                            <!-- Enlace para ver/editar (Asume que crearás un método 'edit' en el controlador) -->
                            <a href="index.php?controller=tarea&action=edit&id=<?php echo $tarea['id_tarea']; ?>">Editar</a> 
                            | 
                            <!-- Enlace para eliminar (Apunta al método 'delete' que ya hicimos) -->
                            <a href="index.php?controller=tarea&action=delete&id=<?php echo $tarea['id_tarea']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta tarea?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Caso: No hay datos en la base de datos -->
                <tr>
                    <td colspan="5">No hay tareas registradas en DataAuditLabs.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>