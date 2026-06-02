<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea - DataAuditLabs</title>
</head>
<body>
    <header style="background-color: #f4f4f4; padding: 10px; margin-bottom: 20px;">
    <span>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong></span>
    | <span>Rol: <i><?php echo htmlspecialchars($_SESSION['rol']); ?></i></span>
    | <a href="index.php?controller=auth&action=logout">Cerrar Sesión</a>
</header>
    <h1>Editar Tarea #<?php echo $tareaActual['id_tarea']; ?></h1>

    <form action="index.php?controller=tarea&action=actualizar" method="POST">
        
        <input type="hidden" name="id" value="<?php echo $tareaActual['id_tarea']; ?>">

        <p>
            <label for="titulo">Título de la Tarea:</label><br>
            <input type="text" id="titulo" name="titulo" required 
                   value="<?php echo htmlspecialchars($tareaActual['titulo']); ?>">
        </p>

        <p>
            <label for="descripcion">Descripción de la tarea:</label><br>
            <input type="text" id="descripcion" name="descripcion" required 
                   value="<?php echo htmlspecialchars($tareaActual['descripcion']); ?>">
        </p>

        <p>
            <label for="fecha_limite">Fecha límite:</label><br>
            <input type="date" id="fecha_limite" name="fecha_limite" required 
                   value="<?php echo $tareaActual['fecha_limite']; ?>">
        </p>

        <p>
            <button type="submit">Actualizar Tarea</button>
            <a href="index.php?controller=tarea&action=index">Cancelar</a>
        </p>

    </form>

</body>
</html>