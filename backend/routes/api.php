<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PacienteDiaController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\ChamadaController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Rotas de API para pacientes
Route::apiResource('paciente', PacienteController::class);




Route::prefix('paciente-dia')->group(function () {

    // Lista pacientes do dia (filtro por sala, turno, perfil)
    Route::get('/', [PacienteDiaController::class, 'index']);

    // Criar paciente do dia (check-in / paciente extra)
    Route::post('/', [PacienteDiaController::class, 'store']);

    // Atualizar dados gerais (observação, sala_dia, turno_dia)
    Route::put('{id}', [PacienteDiaController::class, 'update']);

    // Remover paciente do dia
    Route::delete('{id}', [PacienteDiaController::class, 'destroy']);
});






Route::prefix('chamada')->group(function () {

    // Recepção marca que o paciente chegou
    Route::put('{id}/chegou', [ChamadaController::class, 'chegou']);

    // Médico chama o paciente
    Route::put('{id}/chamar', [ChamadaController::class, 'chamar']);

    // Chamar novamente (voz / painel)
    Route::post('{id}/chamar-novamente', [ChamadaController::class, 'chamarNovamente']);

    // Chamar acompanhante
    Route::post('{id}/chamar-acompanhante', [ChamadaController::class, 'chamarAcompanhante']);

    // Trocar sala do dia
    // Route::post('{id}/trocar-sala', [ChamadaController::class, 'trocarSala']);
});








// Route::prefix('painel')->group(function () {

//     // Último paciente chamado por sala
//     Route::get('ultimos', [PainelController::class, 'ultimosChamados']);

//     // Próximo paciente a chamar (voz)
//     Route::get('proximo', [PainelController::class, 'proximoParaChamar']);

//     // Marcar como já anunciado no painel
//     Route::post('{id}/confirmar-chamada', [PainelController::class, 'confirmarChamada']);
// });
