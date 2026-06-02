<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tareas - DataAuditLabs</title>
</head>
<body>
    <header style="background-color: #f4f4f4; padding: 10px; margin-bottom: 20px;">
    <span>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong></span>
    | <span>Rol: <i><?php echo htmlspecialchars($_SESSION['rol']); ?></i></span>
    | <a href="index.php?controller=auth&action=logout">Cerrar Sesión</a>
</header>

<a href="index.php?controller=proyecto&action=index">Ver Proyectos</a> 
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
                <th>Fecha creacion</th>
                <th>Fecha Limite</th>
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
                        <td>
                            <select onchange="cambiarProyectoAjax(<?php echo $tarea['id_tarea']; ?>, this.value)">
                                <?php if (!empty($proyectos)): ?>
                                    <?php foreach ($proyectos as $p): ?>
                                        <option value="<?php echo $p['id_proyecto']; ?>" 
                                            <?php echo ($tarea['id_proyecto'] == $p['id_proyecto']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($p['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Sin proyectos</option>
                                <?php endif; ?>
                            </select>
                        </td>
                        <td>
                            <select onchange="cambiarEstadoAjax(<?php echo $tarea['id_tarea']; ?>, this.value)">
                                <option value="Pendiente" <?php echo ($tarea['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="En Progreso" <?php echo ($tarea['estado'] == 'En Progreso') ? 'selected' : ''; ?>>En Progreso</option>
                                <option value="Revisión" <?php echo ($tarea['estado'] == 'Revisión') ? 'selected' : ''; ?>>Revisión</option>
                                <option value="Testing" <?php echo ($tarea['estado'] == 'Testing') ? 'selected' : ''; ?>>Testing</option>
                                <option value="Completada" <?php echo ($tarea['estado'] == 'Completada') ? 'selected' : ''; ?>>Completada</option>
                            </select>
                        </td>
                        <td>
                    <select onchange="cambiarPrioridadAjax(<?php echo $tarea['id_tarea']; ?>, this.value)">
                        <option value="Baja" <?php echo ($tarea['prioridad'] == 'Baja') ? 'selected' : ''; ?>>Baja</option>
                <option value="Media" <?php echo ($tarea['prioridad'] == 'Media') ? 'selected' : ''; ?>>Media</option>
                <option value="Alta" <?php echo ($tarea['prioridad'] == 'Alta') ? 'selected' : ''; ?>>Alta</option>
                <option value="Urgente" <?php echo ($tarea['prioridad'] == 'Urgente') ? 'selected' : ''; ?>>Urgente</option>
                    </select>

                    </td>
                    <td><?php echo $tarea['fecha_creacion']; ?></td>
                    <td><?php echo $tarea['fecha_limite']; ?></td>
                        
                        <!-- 5. Enlaces de Acción (Pasando el ID por GET) -->
                        <td>
                            <!-- Enlace para ver/editar (Asume que crearás un método 'edit' en el controlador) -->
                            <a href="index.php?controller=tarea&action=edit&id=<?php echo $tarea['id_tarea']; ?>">Editar</a> 
                            | <button type="button" onclick="eliminarConAjax(<?php echo $tarea['id_tarea']; ?>, this)">Eliminar (AJAX)</button>
                         
                          
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
<script>
    function cambiarEstadoAjax(id_tarea, nuevoEstado) {
    
    // Empaquetamos los datos como si fuera un formulario HTML invisible
    let formData = new FormData();
    formData.append('id', id_tarea);
    formData.append('estado', nuevoEstado);

    // Hacemos la petición POST al controlador
    fetch('index.php?controller=tarea&action=actualizarEstadoAjax', {
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
function cambiarPrioridadAjax(id_tarea, nuevaPrioridad) {
    
    // Empaquetamos los datos como si fuera un formulario HTML invisible
    let formData = new FormData();
    formData.append('id', id_tarea);
    formData.append('prioridad', nuevaPrioridad);

    // Hacemos la petición POST al controlador
    fetch('index.php?controller=tarea&action=actualizarPrioridadAjax', {
        method: 'POST',
        body: formData
    })
    .then(respuesta => respuesta.json()) // Esperamos la respuesta en JSON
    .then(datos => {
        if (datos.success) {
            // Éxito: Podemos imprimir en consola o no hacer nada (modo silencioso)
            console.log("Cambio guardado: " + nuevaPrioridad);
            
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

function eliminarConAjax(id_tarea, botonClicado) {
    // 1. Confirmación clásica
    if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
        
        // 2. Hacemos la petición a la nueva URL de tu controlador
        fetch('index.php?controller=tarea&action=eliminarAjax&id=' + id_tarea)
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