<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/styles.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

    <h1>Registrar Nuevo Usuario</h1>

    <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px;">
            <strong>Error:</strong> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=auth&action=storeRegistro" method="POST">
        
        <p>
            <label for="nombre">Nombre Completo:</label><br>
            <input type="text" id="nombre" name="nombre" required placeholder="Ej. Juan Pérez">
        </p>

        <p>
            <label for="email">Correo Electrónico:</label><br>
            <input type="email" id="email" name="email" required placeholder="correo@dataauditlabs.com">
        </p>

        <p>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required>
        </p>

        <p>
            <label for="rol">Rol en el equipo:</label><br>
            <select id="rol" name="rol" required>
                <option value="Analista">Analista</option>
                <option value="Desarrollador Frontend">Desarrollador Frontend</option>
                <option value="Desarrollador Backend">Desarrollador Backend</option>
                <option value="DBA">DBA</option>
                <option value="Coordinador">Coordinador</option>
            </select>
        </p>

        <p>
            <button type="submit">Registrar Usuario</button>
            <a href="index.php?controller=auth&action=index">Ya tengo cuenta, iniciar sesión</a>
        </p>

    </form>

</body>
</html>