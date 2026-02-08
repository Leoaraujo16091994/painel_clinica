<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PacienteDia;

class ChamadaController extends Controller
{
    public function chegou(int $id)
    {
       $pacienteDia = PacienteDia::findOrFail($id);

        $pacienteDia->update([
            'chegou' => true,
        ]);

        return response()->json(['success' => true]);
    }

    public function chamar(int $id)
    {
         // Médico chama o paciente
        // Route::post('{id}/chamar', [ChamadaController::class, 'chamar']);
       $pacienteDia = PacienteDia::findOrFail($id);

        $pacienteDia->update([
            'chamado' => true,
        ]);

        return response()->json(['success' => true]);
    }
    
    public function chamarNovamente(Request $request, string $id)
    {
        // Chamar novamente (voz / painel)
        // Route::post('{id}/chamar-novamente', [ChamadaController::class, 'chamarNovamente']);
    }
    
    public function chamarAcompanhante(Request $request, string $id)
    {
        // Chamar acompanhante
        // Route::post('{id}/chamar-acompanhante', [ChamadaController::class, 'chamarAcompanhante']);
    }
    
    // ACHO Q NAO PRECISA POIS VOU COLOCAR NA PACIENTE DIA CONTROLLER
    // public function trocarSala(Request $request, string $id)
    // {
       // Trocar sala do dia
       // Route::post('{id}/trocar-sala', [ChamadaController::class, 'trocarSala']);
    // }
}




   
    

    

    

