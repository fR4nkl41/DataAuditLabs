@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Mis Tareas</h3>
    <a href="{{ route('tareas.create') }}" class="btn btn-primary">+ Nueva Tarea</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tareas as $tarea)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tarea->titulo }}</td>
                    <td>{{ $tarea->descripcion }}</td>
                    <td>
                        <span class="badge 
                            @if($tarea->estado == 'pendiente') bg-warning text-dark
                            @elseif($tarea->estado == 'en_progreso') bg-primary
                            @else bg-success @endif">
                            {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('tareas.edit', $tarea->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form method="POST" action="{{ route('tareas.destroy', $tarea->id) }}" class="d-inline" onsubmit="return confirm('¿Eliminar esta tarea?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No tienes tareas aún. ¡Crea una!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection