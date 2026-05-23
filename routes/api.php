<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccesoController;

Route::get('/accesos/{rolId}', [AccesoController::class, 'getAccesosPorRol']);

