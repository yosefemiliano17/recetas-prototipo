<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetaController;


Route::get('/', function () {
    return redirect()->route('recetas.create');
});

Route::match(['get', 'post'], '/recetas/crear', [RecetaController::class, 'create'])->name('recetas.create');
Route::post('/recetas', [RecetaController::class, 'store'])->name('recetas.store');
Route::get('/sucursal/{id}', [RecetaController::class, 'show'])->name('recetas.show');
