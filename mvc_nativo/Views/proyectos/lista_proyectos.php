<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyectos - DataAuditLabs</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Gestión de Proyectos</h1>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'proyecto_creado'): ?>
        <div style="color: green; margin-bottom: 15px; border: 1px solid green; padding: 10px;">
            El proyecto fue guardado exitosamente.
        </div>
    <?php endif; ?>

    <p>
        <a href="index.php?controller=proyecto&action=create">
            <button>+ Crear Nuevo Proyecto</button>
        </a>
        <a href="index.php?controller=tarea&action=index" style="margin-left: 10px;">
            Ir a mis Tareas
        </a>
    </p>
   

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Proyecto</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha de Inicio</th>
                <th>Fecha Fin Estimada</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($proyectos)): ?>
                <?php foreach ($proyectos as $proyecto): ?>
                    <tr>
                        <td><?php echo $proyecto['id_proyecto']; ?></td>
                        <td><strong><?php echo htmlspecialchars($proyecto['nombre']); ?></strong></td>
                        <td><?php echo htmlspecialchars($proyecto['descripcion'] ?? 'Sin descripción'); ?></td>
                        <td><?php echo htmlspecialchars($proyecto['estado']); ?></td>
                        <td><?php echo $proyecto['fecha_inicio'] ? $proyecto['fecha_inicio'] : 'N/A'; ?></td>
                        <td><?php echo $proyecto['fecha_fin_estimada'] ? $proyecto['fecha_fin_estimada'] : 'N/A'; ?></td>
                        <td>
                            <a href="index.php?controller=proyecto&action=edit&id=<?php echo $proyecto['id_proyecto']; ?>">
                                Editar
                            </a>
                              <a href="index.php?controller=proyecto&action=delete&id=<?php echo $proyecto['id_proyecto']; ?>" onclick="return confirm('¿Estás seguro de eliminar este Proyecto?');">Eliminar</a>
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay proyectos registrados aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>