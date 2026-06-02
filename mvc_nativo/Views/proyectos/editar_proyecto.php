<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proyecto - DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/styles.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

    <h1>Editar Proyecto #<?php echo $proyectoActual['id_proyecto']; ?></h1>

    <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px;">
            <strong>Error:</strong> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=proyecto&action=actualizar" method="POST">
        
        <input type="hidden" name="id" value="<?php echo $proyectoActual['id_proyecto']; ?>">

        <p>
            <label for="nombre">Nombre del Proyecto: *</label><br>
            <input type="text" id="nombre" name="nombre" required 
                   value="<?php echo htmlspecialchars($proyectoActual['nombre']); ?>">
        </p>

        <p>
            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50"><?php echo htmlspecialchars($proyectoActual['descripcion'] ?? ''); ?></textarea>
        </p>

        <p>
            <label for="fecha_inicio">Fecha de Inicio:</label><br>
            <input type="date" id="fecha_inicio" name="fecha_inicio" 
                   value="<?php echo $proyectoActual['fecha_inicio']; ?>">
        </p>

        <p>
            <label for="fecha_fin_estimada">Fecha Fin Estimada:</label><br>
            <input type="date" id="fecha_fin_estimada" name="fecha_fin_estimada" 
                   value="<?php echo $proyectoActual['fecha_fin_estimada']; ?>">
        </p>

        <p>
            <label for="estado">Estado del Proyecto:</label><br>
            <select id="estado" name="estado" required>
                <option value="Planificacion" <?php echo ($proyectoActual['estado'] == 'Planificacion') ? 'selected' : ''; ?>>Planificación</option>
                <option value="En Desarrollo" <?php echo ($proyectoActual['estado'] == 'En Desarrollo') ? 'selected' : ''; ?>>En Desarrollo</option>
                <option value="Pruebas" <?php echo ($proyectoActual['estado'] == 'Pruebas') ? 'selected' : ''; ?>>Pruebas</option>
                <option value="Completado" <?php echo ($proyectoActual['estado'] == 'Completado') ? 'selected' : ''; ?>>Completado</option>
            </select>
        </p>

        <p>
            <button type="submit">Actualizar Proyecto</button>
            <a href="index.php?controller=proyecto&action=index">Cancelar</a>
        </p>

    </form>

</body>
</html>