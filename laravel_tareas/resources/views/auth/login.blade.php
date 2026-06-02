<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

    <h1>Iniciar Sesión</h1>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px; background-color: white; border-radius: 8px;">
            <strong>Error:</strong> {{ $errors->first() }}
        </div>
    @endif

    @if (session('mensaje'))
        <div style="color: green; margin-bottom: 15px; border: 1px solid green; padding: 10px; background-color: white; border-radius: 8px;">
            {{ session('mensaje') }}
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf
        
        <p>
            <label for="email">Correo Electrónico:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="admin@dataauditlabs.com">
        </p>

        <p>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required>
        </p>

        <p style="margin-top: 25px;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
            <br><br>
            <a href="/registro" style="display: block; text-align: center; font-size: 0.9rem;">Crear Usuario</a>
        </p>

    </form>

</body>
</html>