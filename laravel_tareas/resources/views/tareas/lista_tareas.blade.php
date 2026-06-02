<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lista de Tareas - DataAuditLabs</title>
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
            <button type="submit">
                Cerrar Sesión
            </button>
        </form>
    </header>
 
    <h1>Gestión de Tareas</h1>

    @if (session('mensaje') == 'creado')
        <div><p><strong>Éxito:</strong> La tarea se creó correctamente.</p></div>
    @elseif (session('mensaje') == 'eliminado')
        <div><p><strong>Éxito:</strong> La tarea fue eliminada.</p></div>
    @endif

    <p>
        <a href="/tareas/crear">Crear Nueva Tarea</a> |
        <a href="/proyectos">Ver Proyectos</a>
    </p>

    <table border="1" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Proyecto</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Fecha Creación</th>
                <th>Fecha Límite</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tareas as $tarea)
                <tr>
                    <td>{{ $tarea->id_tarea }}</td>
                    <td>{{ $tarea->titulo }}</td>
                    <td>
                        <select onchange="cambiarProyectoAjax({{ $tarea->id_tarea }}, this.value)">
                            @foreach ($proyectos as $p)
                                <option value="{{ $p->id_proyecto }}" {{ $tarea->id_proyecto == $p->id_proyecto ? 'selected' : '' }}>
                                    {{ $p->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select onchange="cambiarEstadoAjax({{ $tarea->id_tarea }}, this.value)">
                            <option value="Pendiente" {{ $tarea->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En Progreso" {{ $tarea->estado == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="Revisión" {{ $tarea->estado == 'Revisión' ? 'selected' : '' }}>Revisión</option>
                            <option value="Testing" {{ $tarea->estado == 'Testing' ? 'selected' : '' }}>Testing</option>
                            <option value="Completada" {{ $tarea->estado == 'Completada' ? 'selected' : '' }}>Completada</option>
                        </select>
                    </td>
                    <td>
                        <select onchange="cambiarPrioridadAjax({{ $tarea->id_tarea }}, this.value)">
                            <option value="Baja" {{ $tarea->prioridad == 'Baja' ? 'selected' : '' }}>Baja</option>
                            <option value="Media" {{ $tarea->prioridad == 'Media' ? 'selected' : '' }}>Media</option>
                            <option value="Alta" {{ $tarea->prioridad == 'Alta' ? 'selected' : '' }}>Alta</option>
                            <option value="Urgente" {{ $tarea->prioridad == 'Urgente' ? 'selected' : '' }}>Urgente</option>
                        </select>
                    </td>
                    <td>{{ $tarea->fecha_creacion }}</td>
                    <td>{{ $tarea->fecha_limite }}</td>
                    <td>
                        <a href="/tareas/editar/{{ $tarea->id_tarea }}">Editar</a> |
                        <button type="button" onclick="eliminarConAjax({{ $tarea->id_tarea }}, this)">Eliminar (AJAX)</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay tareas registradas en DataAuditLabs.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function cambiarEstadoAjax(id_tarea, nuevoEstado) {
    let formData = new FormData();
    formData.append('id', id_tarea);
    formData.append('estado', nuevoEstado);
    
    fetch('/tareas/actualizar-estado', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
    })
    .then(respuesta => respuesta.json())
    .then(datos => {
        if (!datos.success) alert('Error: ' + datos.mensaje);
    })
    .catch(error => console.error('Error:', error));
}

function cambiarPrioridadAjax(id_tarea, nuevaPrioridad) {
    let formData = new FormData();
    formData.append('id', id_tarea);
    formData.append('prioridad', nuevaPrioridad);

    fetch('/tareas/actualizar-prioridad', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
    })
    .then(respuesta => respuesta.json())
    .then(datos => {
        if (!datos.success) alert('Error: ' + datos.mensaje);
    })
    .catch(error => console.error('Error:', error));
}

function cambiarProyectoAjax(id_tarea, nuevoIdProyecto) {
    let formData = new FormData();
    formData.append('id', id_tarea);
    formData.append('id_proyecto', nuevoIdProyecto);

    fetch('/tareas/actualizar-proyecto', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
    })
    .then(respuesta => respuesta.json())
    .then(datos => {
        if (!datos.success) alert('Error: ' + datos.mensaje);
    })
    .catch(error => console.error('Error:', error));
}

function eliminarConAjax(id_tarea, botonClicado) {
    if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
        let formData = new FormData();
        formData.append('id', id_tarea);

        fetch('/tareas/eliminar-ajax', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
        .then(respuesta => respuesta.json())
        .then(datos => {
            if (datos.success) {
                botonClicado.closest('tr').remove();
            } else {
                alert('Error: ' + datos.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>
</body>
</html>