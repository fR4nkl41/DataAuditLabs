<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Tarea - DataAuditLabs</title>
</head>
<body>
    <header style="background-color: #f4f4f4; padding: 10px; margin-bottom: 20px;">
    <span>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong></span>
    | <span>Rol: <i><?php echo htmlspecialchars($_SESSION['rol']); ?></i></span>
    | <a href="index.php?controller=auth&action=logout">Cerrar Sesión</a>
</header>
    <h1>Crear Nueva Tarea</h1>

    <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px;">
            <strong>Atención:</strong> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=tarea&action=store" method="POST">
        
        <p>
            <label for="titulo">Título de la Tarea:</label><br>
            <input type="text" id="titulo" name="titulo" required placeholder="Ej. Revisar base de datos">
        </p>

        <p>
            <label for="id_proyecto">ID del Proyecto:</label><br>
            <input type="number" id="id_proyecto" name="id_proyecto" required min="1">
        </p>

        <p>
             <label for="descripcion">Descripcion de la tarea</label><br>
            <input type="text" id="descripcion" name="descripcion" required placeholder="Ejemplo cualquier cosa">
        </p>

          <p>
             <label for="fecha_limite">Fecha limite</label><br>
            <input type="date" id="fecha_limite" name="fecha_limite" required ">
        </p>
        <p>
            <label for="estado">Estado de la Tarea:</label><br>
            <select id="estado" name="estado" required>
                <option value="Pendiente">Pendiente</option>
                <option value="En Progreso">En Progreso</option>
                <option value="Revisión">Revisión</option>
                <option value="Testing">Testing</option>
                <option value="Completada">Completada</option>
            </select>
        </p>

        <p>
            <label for="prioridad">Prioridad:</label><br>
            <select id="prioridad" name="prioridad" required>
                <option value="Baja">Baja</option>
                <option value="Media" selected>Media</option>
                <option value="Alta">Alta</option>
                <option value="Urgente">Urgente</option>
            </select>
        </p>

        <p>
            <button type="submit">Guardar Tarea</button>
            
            <a href="index.php?controller=tarea&action=index">Cancelar y Volver</a>
        </p>

    </form>

</body>
</html>