<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//crear receta
Route::match (['GET', 'POST']), '/recetas/crear', [RecetaController::class, 'crearReceta']);
//guardar la receta en bd
Route::post('/recetas/guardar', [RecetaController::class, 'guardarReceta']);
