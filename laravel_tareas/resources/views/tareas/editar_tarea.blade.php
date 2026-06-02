<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea - DataAuditLabs</title>
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
    <h1>Editar Tarea #{{ $tarea->id_tarea }}</h1>

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
    
    <form action="{{ route('tareas.update', $tarea->id_tarea) }}" method="POST">
        @csrf
        @method('PUT')
        
       

        <p>
            <label for="titulo">Título de la Tarea:</label><br>
           <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $tarea->titulo) }}" required>
        </p>
        <p>
            <label for="id_proyecto">Asignar al Proyecto: *</label><br>
            <select id="id_proyecto" name="id_proyecto" required>
                @foreach ($proyectos as $p)
                    <option value="{{ $p->id_proyecto }}" {{ old('id_proyecto', $tarea->id_proyecto) == $p->id_proyecto ? 'selected' : '' }}>
                        {{ $p->nombre }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
             <label for="descripcion">Descripción de la tarea:</label><br>
            <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $tarea->descripcion) }}" required>
        </p>

        <p>
             <label for="fecha_limite">Fecha límite:</label><br>
            <input type="date" id="fecha_limite" name="fecha_limite" value="{{ old('fecha_limite', $tarea->fecha_limite) }}" required>
        </p>

        <p>
            <label for="estado">Estado de la Tarea:</label><br>
            <select id="estado" name="estado" required>
                @foreach(['Pendiente', 'En Progreso', 'Revisión', 'Testing', 'Completada'] as $estado)
                    <option value="{{ $estado }}" {{ old('estado', $tarea->estado) == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="prioridad">Prioridad:</label><br>
            <select id="prioridad" name="prioridad" required>
                @foreach(['Baja', 'Media', 'Alta', 'Urgente'] as $prioridad)
                    <option value="{{ $prioridad }}" {{ old('prioridad', $tarea->prioridad) == $prioridad ? 'selected' : '' }}>{{ $prioridad }}</option>
                @endforeach
            </select>
        </p>

        <p>
            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
            <a href="/tareas" class="btn btn-secondary">Cancelar y Volver</a>
        </p>
    

    </form>

</body>
</html>