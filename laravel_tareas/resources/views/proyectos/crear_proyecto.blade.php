<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Proyecto - DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <h1>Crear Nuevo Proyecto</h1>

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

    <form action="/proyectos" method="POST">
        @csrf
        
        <p>
            <label for="nombre">Nombre del Proyecto: *</label><br>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej. Implementación de Servidores">
        </p>

        <p>
            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50" placeholder="Objetivos generales del proyecto...">{{ old('descripcion') }}</textarea>
        </p>

        <p>
            <label for="fecha_inicio">Fecha de Inicio:</label><br>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
        </p>

        <p>
            <label for="fecha_fin_estimada">Fecha Fin Estimada:</label><br>
            <input type="date" id="fecha_fin_estimada" name="fecha_fin_estimada" value="{{ old('fecha_fin_estimada') }}">
        </p>

        <p>
            <label for="estado">Estado Inicial:</label><br>
            <select id="estado" name="estado" required>
                <option value="Planificacion" {{ old('estado', 'Planificacion') == 'Planificacion' ? 'selected' : '' }}>Planificación</option>
                <option value="En Desarrollo" {{ old('estado') == 'En Desarrollo' ? 'selected' : '' }}>En Desarrollo</option>
                <option value="Pruebas" {{ old('estado') == 'Pruebas' ? 'selected' : '' }}>Pruebas</option>
                <option value="Completada" {{ old('estado') == 'Completada' ? 'selected' : '' }}>Completada</option>
            </select>
        </p>

        <p>
            <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
            <a href="/proyectos" class="btn btn-secondary">Cancelar</a>
        </p>

    </form>

</body>
</html>