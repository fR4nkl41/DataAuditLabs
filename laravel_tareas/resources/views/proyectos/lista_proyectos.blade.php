<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Proyectos - DataAuditLabs</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

    <h1>Gestión de Proyectos</h1>

    @if (session('mensaje') == 'creado')
        <div><p><strong>Éxito:</strong> El proyecto se creó correctamente.</p></div>
    @elseif (session('mensaje') == 'actualizado')
        <div><p><strong>Éxito:</strong> El proyecto se actualizó correctamente.</p></div>
    @endif

    <p>
        <a href="/proyectos/crear" class="btn btn-primary btn-sm">
            + Crear Nuevo Proyecto
        </a>
        <a href="/tareas" class="btn btn-secondary btn-sm" style="margin-left: 10px;">
            Ir a mis Tareas
        </a>
    </p>

    <table class="table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Proyecto</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha de Inicio</th>
                <th>Fecha Fin Estimada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proyectos as $proyecto)
                <tr>
                    <td>{{ $proyecto->id_proyecto }}</td>
                    <td><strong>{{ $proyecto->nombre }}</strong></td>
                    <td>{{ $proyecto->descripcion }}</td>
                    
                    <td>
                        <select onchange="cambiarEstadoAjax({{ $proyecto->id_proyecto }}, this.value)">
                            <option value="Planificacion" {{ $proyecto->estado == 'Planificacion' ? 'selected' : '' }}>Planificación</option>
                            <option value="En Desarrollo" {{ $proyecto->estado == 'En Desarrollo' ? 'selected' : '' }}>En Desarrollo</option>
                            <option value="Pruebas" {{ $proyecto->estado == 'Pruebas' ? 'selected' : '' }}>Pruebas</option>
                            <option value="Completada" {{ $proyecto->estado == 'Completada' ? 'selected' : '' }}>Completada</option>
                        </select>
                    </td>
                    
                    <td>{{ $proyecto->fecha_inicio }}</td>
                    <td>{{ $proyecto->fecha_fin_estimada }}</td>
                    
                    <td>
                        <a href="/proyectos/editar/{{ $proyecto->id_proyecto }}">Editar</a>
                        | <button type="button" onclick="eliminarConAjax({{ $proyecto->id_proyecto }}, this)">Eliminar (AJAX)</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No hay proyectos registrados aún.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<script>
// Capturamos el token de seguridad
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function cambiarEstadoAjax(id_proyecto, nuevoEstado) {
    let formData = new FormData();
    formData.append('id', id_proyecto);
    formData.append('estado', nuevoEstado);

    // Ruta Laravel + Cabecera segura
    fetch('/proyectos/actualizar-estado', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
    })
    .then(respuesta => respuesta.json())
    .then(datos => {
        if (datos.success) {
            console.log("Cambio guardado: " + nuevoEstado);
        } else {
            alert('Error: ' + datos.mensaje);
        }
    })
    .catch(error => {
        console.error('Hubo un problema de conexión:', error);
        alert('Ocurrió un error al intentar comunicar con el servidor.');
    });
}

function eliminarConAjax(id_proyecto, botonClicado) {
    if (confirm('¿Estás seguro de que deseas eliminar este proyecto?')) {
        
        let formData = new FormData();
        formData.append('id', id_proyecto);

        // Eliminación por POST al estilo Laravel
        fetch('/proyectos/eliminar-ajax', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
        .then(respuesta => respuesta.json())
        .then(datos => {
            if (datos.success) {
                let fila = botonClicado.closest('tr');
                fila.remove();
            } else {
                alert('Error: ' + datos.mensaje);
            }
        })
        .catch(error => {
            console.error('Hubo un problema con la petición Fetch:', error);
            alert('Ocurrió un error al intentar comunicar con el servidor.');
        });
    }
}
</script>
</body>
</html>