<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proyecto - DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <h1>Editar Proyecto #{{ $proyecto->id_proyecto }}</h1>
    
    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px;">
            <strong>Atención:</strong> Por favor corrige los errores:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proyectos.update', $proyecto->id_proyecto) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label for="nombre">Nombre del Proyecto: *</label><br>
            <input type="text" id="nombre" name="nombre" required value="{{ old('nombre', $proyecto->nombre) }}">
        </p>

        <p>
            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50" required>{{ old('descripcion', $proyecto->descripcion) }}</textarea>
        </p>

        <p>
            <label for="fecha_inicio">Fecha de Inicio:</label><br>
            <input type="date" id="fecha_inicio" name="fecha_inicio" 
                   value="{{ old('fecha_inicio', $proyecto->fecha_inicio) }}">
        </p>

        <p>
            <label for="fecha_fin_estimada">Fecha Fin Estimada:</label><br>
            <input type="date" id="fecha_fin_estimada" name="fecha_fin_estimada" 
                   value="{{ old('fecha_fin_estimada', $proyecto->fecha_fin_estimada) }}">
        </p>

        <p>
            <label for="estado">Estado del Proyecto:</label><br>
            <select id="estado" name="estado" required>
                <option value="Planificacion" {{ old('estado', $proyecto->estado) == 'Planificacion' ? 'selected' : '' }}>Planificación</option>
                <option value="En Desarrollo" {{ old('estado', $proyecto->estado) == 'En Desarrollo' ? 'selected' : '' }}>En Desarrollo</option>
                <option value="Pruebas" {{ old('estado', $proyecto->estado) == 'Pruebas' ? 'selected' : '' }}>Pruebas</option>
                <option value="Completada" {{ old('estado', $proyecto->estado) == 'Completada' ? 'selected' : '' }}>Completada</option>
            </select>
        </p>

        <p>
            <button type="submit" class="btn btn-primary">Actualizar Proyecto</button>
            <a href="/proyectos" class="btn btn-secondary">Cancelar</a>
        </p>

    </form>

</body>
</html>