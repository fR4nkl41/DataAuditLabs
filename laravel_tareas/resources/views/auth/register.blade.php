<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

    <h1>Registrar Nuevo Usuario</h1>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px;">
            <strong>Atención:</strong> Por favor corrige los siguientes errores:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/registro" method="POST">
        @csrf
        
        <p>
            <label for="nombre">Nombre Completo:</label><br>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej. Juan Pérez">
        </p>

        <p>
            <label for="email">Correo Electrónico:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="correo@dataauditlabs.com">
        </p>

        <p>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required>
        </p>

        <p>
            <label for="rol">Rol en el equipo:</label><br>
            <select id="rol" name="rol" required>
                <option value="Analista" {{ old('rol') == 'Analista' ? 'selected' : '' }}>Analista</option>
                <option value="Desarrollador Frontend" {{ old('rol') == 'Desarrollador Frontend' ? 'selected' : '' }}>Desarrollador Frontend</option>
                <option value="Desarrollador Backend" {{ old('rol') == 'Desarrollador Backend' ? 'selected' : '' }}>Desarrollador Backend</option>
                <option value="DBA" {{ old('rol') == 'DBA' ? 'selected' : '' }}>DBA</option>
                <option value="Coordinador" {{ old('rol') == 'Coordinador' ? 'selected' : '' }}>Coordinador</option>
            </select>
        </p>

        <p>
            <button type="submit" class="btn btn-primary">Registrar Usuario</button>
            <a href="/login" class="btn btn-secondary">Ya tengo cuenta, iniciar sesión</a>
        </p>

    </form>

</body>
</html>