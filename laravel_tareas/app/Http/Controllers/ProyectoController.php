<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::all();
        return view('proyectos.lista_proyectos', compact('proyectos'));
    }
     public function create()
    {
        return view('proyectos.crear_proyecto');
    }
    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required',
        ]);

        $proyecto = new Proyecto($request->all());
        $proyecto->save();

        return redirect()->route('proyectos.index')->with('mensaje', 'creado');
    }

    public function actualizarEstadoAjax(Request $request) {
        $proyecto = Proyecto::where('id_proyecto', $request->id)->first();
        if ($proyecto) {
            $proyecto->estado = $request->estado;
            $proyecto->save();
            return response()->json(['success' => true, 'mensaje' => 'Estado actualizado']);
        }
        return response()->json(['success' => false, 'mensaje' => 'Proyecto no encontrado']);
    }
     public function eliminarAjax(Request $request) {
        $proyecto = Proyecto::find($request->id);
        if ($proyecto) {
            $proyecto->delete();
            return response()->json(['success' => true, 'mensaje' => 'Proyecto eliminado']);
        }
        return response()->json(['success' => false, 'mensaje' => 'Error al eliminar']);
    }

     public function edit($id)
    {
        // findOrFail busca por la llave primaria (id_tarea); si no existe, lanza un error 404 automáticamente
        $proyecto = Proyecto::findOrFail($id); 

        return view('proyectos.editar_proyecto', compact('proyecto'));
    }
    public function update(Request $request, $id)
    {
        // Validamos que los datos requeridos vengan listos
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ]);

        $proyecto = Proyecto::findOrFail($id);
        

        $proyecto->update($request->all());

        return redirect()->route('proyectos.index')->with('mensaje', 'actualizado');
    }


}
