<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    // 1. El nombre real de la tabla en tu base de datos
    protected $table = 'proyectos';

    // 2. Tu llave primaria personalizada
    protected $primaryKey = 'id_proyecto';

    // 3. Desactivar timestamps si no tienes created_at y updated_at en esta tabla
    public $timestamps = false;

    // 4. Los campos que permites insertar/editar
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'fecha_inicio',
        'fecha_fin_estimada' 
    ];
}
