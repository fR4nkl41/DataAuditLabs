<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Tarea - DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
    <header>
        <span>Bienvenido, <strong>{{ auth()->user()->nombre ?? 'Usuario' }}</strong></span>
        <span style="color: #e8eaf6; margin: 0 5px;">|</span>
        <span>Rol: <strong style="color: var(--accent);">{{ auth()->user()->rol ?? 'N/A' }}</strong></span>
        <span style="color: #e8eaf6; margin: 0 5px;">|</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline; margin: 0; padding: 0;">
            @csrf
            <button type="submit" >
                Cerrar Sesión
            </button>
        </form>
    </header>

    <h1>Crear Nueva Tarea</h1>

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

    <form action="/tareas" method="POST">
        @csrf
        
        <p>
            <label for="titulo">Título de la Tarea:</label><br>
            <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required placeholder="Ej. Revisar base de datos">
        </p>

       <p>
            <label for="id_proyecto">Asignar al Proyecto: *</label><br>
            <select id="id_proyecto" name="id_proyecto" required>
                <option value="">-- Selecciona un Proyecto --</option>
                
                @forelse ($proyectos as $p)
                    <option value="{{ $p->id_proyecto }}" {{ old('id_proyecto') == $p->id_proyecto ? 'selected' : '' }}>
                        {{ $p->nombre }}
                    </option>
                @empty
                    <option value="">No hay proyectos disponibles</option>
                @endforelse
                
            </select>
        </p>

        <p>
             <label for="descripcion">Descripcion de la tarea:</label><br>
            <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required placeholder="Ejemplo cualquier cosa">
        </p>

        <p>
             <label for="fecha_limite">Fecha limite:</label><br>
            <input type="date" id="fecha_limite" name="fecha_limite" value="{{ old('fecha_limite') }}" required>
        </p>

        <p>
            <label for="estado">Estado de la Tarea:</label><br>
            <select id="estado" name="estado" required>
                <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="En Progreso" {{ old('estado') == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>
                <option value="Revisión" {{ old('estado') == 'Revisión' ? 'selected' : '' }}>Revisión</option>
                <option value="Testing" {{ old('estado') == 'Testing' ? 'selected' : '' }}>Testing</option>
                <option value="Completada" {{ old('estado') == 'Completada' ? 'selected' : '' }}>Completada</option>
            </select>
        </p>

        <p>
            <label for="prioridad">Prioridad:</label><br>
            <select id="prioridad" name="prioridad" required>
                <option value="Baja" {{ old('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                <option value="Media" {{ old('prioridad', 'Media') == 'Media' ? 'selected' : '' }}>Media</option>
                <option value="Alta" {{ old('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                <option value="Urgente" {{ old('prioridad') == 'Urgente' ? 'selected' : '' }}>Urgente</option>
            </select>
        </p>

        <p>
            <button type="submit" class="btn btn-primary">Guardar Tarea</button>
            <a href="/tareas" class="btn btn-secondary">Cancelar y Volver</a>
        </p>

    </form>

</body>
</html>