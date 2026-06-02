<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    
    public function index()
    {
        $tareas = Tarea::where('id_usuario_asignado', auth()->id())->get();
        $proyectos = Proyecto::all();
        return view('tareas.lista_tareas', compact('tareas', 'proyectos'));
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return view('tareas.crear_tarea', compact('proyectos'));
    }
    public function edit($id)
    {
        // findOrFail busca por la llave primaria (id_tarea); si no existe, lanza un error 404 automáticamente
        $tarea = Tarea::findOrFail($id); 
        $proyectos = Proyecto::all();

        return view('tareas.editar_tarea', compact('tarea', 'proyectos'));
    }
    public function update(Request $request, $id)
    {
        // Validamos que los datos requeridos vengan listos
        $request->validate([
            'titulo' => 'required',
            'id_proyecto' => 'required',
            'descripcion' => 'required',
            'fecha_limite' => 'required'
        ]);

        $tarea = Tarea::findOrFail($id);
        

        $tarea->update($request->all());

        return redirect()->route('tareas.index')->with('mensaje', 'actualizado');
    }


    public function store(Request $request) {
        $request->validate([
            'titulo' => 'required',
            'id_proyecto' => 'required'
        ]);

        $tarea = new Tarea($request->all());
        $tarea->id_usuario_asignado = auth()->id();
        $tarea->save();

        return redirect()->route('tareas.index')->with('mensaje', 'creado');
    }

    public function actualizarEstadoAjax(Request $request) {
        $tarea = Tarea::where('id_tarea', $request->id)->first();
        if ($tarea) {
            $tarea->estado = $request->estado;
            $tarea->save();
            return response()->json(['success' => true, 'mensaje' => 'Estado actualizado']);
        }
        return response()->json(['success' => false, 'mensaje' => 'Tarea no encontrada']);
    }

    public function actualizarPrioridadAjax(Request $request) {
        $tarea = Tarea::find($request->id);
        if ($tarea) {
            $tarea->prioridad = $request->prioridad;
            $tarea->save();
            return response()->json(['success' => true, 'mensaje' => 'Prioridad actualizada']);
        }
        return response()->json(['success' => false, 'mensaje' => 'Tarea no encontrada']);
    }

    public function actualizarProyectoAjax(Request $request) {
        $tarea = Tarea::find($request->id);
        if ($tarea) {
            $tarea->id_proyecto = $request->id_proyecto;
            $tarea->save();
            return response()->json(['success' => true, 'mensaje' => 'Proyecto actualizado']);
        }
        return response()->json(['success' => false, 'mensaje' => 'Tarea no encontrada']);
    }

    public function eliminarAjax(Request $request) {
        $tarea = Tarea::find($request->id);
        if ($tarea) {
            $tarea->delete();
            return response()->json(['success' => true, 'mensaje' => 'Tarea eliminada']);
        }
        return response()->json(['success' => false, 'mensaje' => 'Error al eliminar']);
    }
}
