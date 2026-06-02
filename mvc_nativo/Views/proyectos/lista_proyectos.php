<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyectos - DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/styles.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
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
            + Crear Nuevo Proyecto
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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($proyectos)): ?>
                <?php foreach ($proyectos as $proyecto): ?>
                    <tr>
                        <td><?php echo $proyecto['id_proyecto']; ?></td>
                        <td><strong><?php echo htmlspecialchars($proyecto['nombre']); ?></strong></td>
                        <td><?php echo htmlspecialchars($proyecto['descripcion'] ?? 'Sin descripción'); ?></td>
                        <td>
                            <select onchange="cambiarEstadoAjax(<?php echo $proyecto['id_proyecto']; ?>, this.value)">
                                <option value="Planificacion" <?php echo ($proyecto['estado'] == 'Planificacion') ? 'selected' : ''; ?>>Planificación</option>
                                <option value="En Desarrollo" <?php echo ($proyecto['estado'] == 'En Desarrollo') ? 'selected' : ''; ?>>En Desarrollo</option>
                                <option value="Pruebas" <?php echo ($proyecto['estado'] == 'Pruebas') ? 'selected' : ''; ?>>Pruebas</option>
                                <option value="Completado" <?php echo ($proyecto['estado'] == 'Completado') ? 'selected' : ''; ?>>Completado</option>
                            </select>
                        </td>
                        <td><?php echo $proyecto['fecha_inicio'] ? $proyecto['fecha_inicio'] : 'N/A'; ?></td>
                        <td><?php echo $proyecto['fecha_fin_estimada'] ? $proyecto['fecha_fin_estimada'] : 'N/A'; ?></td>
                        <td>
                            <a href="index.php?controller=proyecto&action=edit&id=<?php echo $proyecto['id_proyecto']; ?>">
                                Editar
                            </a>
                            <button type="button" onclick="eliminarConAjax(<?php echo $proyecto['id_proyecto']; ?>, this)">Eliminar (AJAX)</button>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay proyectos registrados aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<script>
    function cambiarEstadoAjax(id_proyecto, nuevoEstado) {
    
    // Empaquetamos los datos como si fuera un formulario HTML invisible
    let formData = new FormData();
    formData.append('id', id_proyecto);
    formData.append('estado', nuevoEstado);

    // Hacemos la petición POST al controlador
    fetch('index.php?controller=proyecto&action=actualizarEstadoAjax', {
        method: 'POST',
        body: formData
    })
    .then(respuesta => respuesta.json()) // Esperamos la respuesta en JSON
    .then(datos => {
        if (datos.success) {
            // Éxito: Podemos imprimir en consola o no hacer nada (modo silencioso)
            console.log("Cambio guardado: " + nuevoEstado);
            
            // Opcional: Mostrar un aviso visual temporal si lo deseas
            // alert('Estado guardado correctamente'); 
        } else {
            // El servidor reportó un error
            alert('Error: ' + datos.mensaje);
        }
    })
    .catch(error => {
        console.error('Hubo un problema de conexión:', error);
        alert('Ocurrió un error al intentar comunicar con el servidor.');
    });
}

function eliminarConAjax(id_proyecto, botonClicado) {
    // 1. Confirmación clásica
    if (confirm('¿Estás seguro de que deseas eliminar este proyecto?')) {
        
        // 2. Hacemos la petición a la nueva URL de tu controlador
        fetch('index.php?controller=proyecto&action=eliminarAjax&id=' + id_proyecto)
            .then(respuesta => respuesta.json()) // Convertimos la respuesta de PHP a un objeto JS
            .then(datos => {
                
                if (datos.success) {
                    // 3. Si PHP dice que se borró, eliminamos la fila (<tr>) de la tabla HTML
                    let fila = botonClicado.closest('tr');
                    fila.remove();
                    
                    // Opcional: Mostrar un pequeño mensaje flotante o alert
                    // alert(datos.mensaje);
                } else {
                    // Si hubo un error en el servidor, lo mostramos
                    alert('Error: ' + datos.mensaje);
                }
                
            })
            .catch(error => {
                console.error('Hubo un problema con la petición Fetch:', error);
                alert('Ocurrió un error al intentar comunicar con el servidor.');
            });
    }
}
</script>
</body>
</html>