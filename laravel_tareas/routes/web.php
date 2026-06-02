<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;

// 1. Redirección inteligente en la raíz
Route::get('/', function () {
    if (Auth::check()) {
        // Si ya hay una sesión activa, lo mandamos a su panel
        return redirect('/tareas'); 
    }
    // Si es un visitante nuevo, va al login
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/registro', [AuthController::class, 'showRegister']);
Route::post('/registro', [AuthController::class, 'register']);

// Rutas protegidas (Requieren haber iniciado sesión)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Módulo de Proyectos
    Route::get('/proyectos', [ProyectoController::class, 'index']);
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
    Route::post('/proyectos',[ProyectoController::class, 'store'] );
    Route::get('/proyectos/crear', [ProyectoController::class, 'create']);
    Route::post('/proyectos/actualizar-estado', [ProyectoController::class, 'actualizarEstadoAjax']);
    Route::post('/proyectos/eliminar-ajax', [ProyectoController::class, 'eliminarAjax']);
     Route::get('/proyectos/editar/{id}', [ProyectoController::class, 'edit'])->name('proyectos.edit');
    Route::put('/proyectos/actualizar/{id}', [ProyectoController::class, 'update'])->name('proyectos.update');
    // Módulo de Tareas Tradicional
    Route::get('/tareas', [TareaController::class, 'index'])->name('tareas.index');
    Route::post('/tareas', [TareaController::class, 'store']);
    //Rutas: crear tareas
    Route::get('/tareas/crear', [TareaController::class, 'create']);
    // Rutas para el Submódulo de Edición
    Route::get('/tareas/editar/{id}', [TareaController::class, 'edit'])->name('tareas.edit');
    Route::put('/tareas/actualizar/{id}', [TareaController::class, 'update'])->name('tareas.update');

    // Peticiones de AJAX
    Route::post('/tareas/actualizar-estado', [TareaController::class, 'actualizarEstadoAjax']);
    Route::post('/tareas/actualizar-prioridad', [TareaController::class, 'actualizarPrioridadAjax']);
    Route::post('/tareas/actualizar-proyecto', [TareaController::class, 'actualizarProyectoAjax']);
    Route::post('/tareas/eliminar-ajax', [TareaController::class, 'eliminarAjax']);
});