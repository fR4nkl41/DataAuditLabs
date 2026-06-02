<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{   
    //Especificamos que tabla usar a laravel
    protected $table = 'tareas';
    //Pasamos la key principal
    protected $primaryKey = 'id_tarea';

    public $timestamps = false;
    //Dirigimos que tablas se pueden llenar masivamente
    protected $fillable = [
        'id_proyecto', 
        'id_usuario_asignado', 
        'titulo', 
        'descripcion', 
        'estado', 
        'prioridad', 
        'fecha_limite'
    ];


}
