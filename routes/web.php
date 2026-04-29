<?php

use Illuminate\Support\Facades\Route;

// Redirigir todas las rutas a la vista principal para que Vue Router las maneje
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
