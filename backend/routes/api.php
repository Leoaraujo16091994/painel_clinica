<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Rotas de API para pacientes
Route::apiResource('paciente', PacienteController::class);