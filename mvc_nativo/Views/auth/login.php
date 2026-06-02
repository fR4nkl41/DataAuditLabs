<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - DataAuditLabs</title>
</head>
<body>

    <h1>Iniciar Sesión</h1>

    <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px;">
            <strong>Error:</strong> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=auth&action=login" method="POST">
        <p>
             <a href="index.php?controller=auth&action=registro">Crear Usuario</a>
    </p>
        <p>
            <label for="email">Correo Electrónico:</label><br>
            <input type="email" id="email" name="email" required placeholder="admin@dataauditlabs.com">
        </p>

        <p>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required>
        </p>

        <p>
            <button type="submit">Entrar</button>
        </p>

    </form>

</body>
</html>