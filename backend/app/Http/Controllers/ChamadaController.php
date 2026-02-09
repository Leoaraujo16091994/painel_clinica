<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PacienteDia;
use App\Events\PacienteChamado;

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
        
        $pacienteDia = PacienteDia::with('paciente')->findOrFail($id);
        $pacienteDia->update([
            'chamado' => true,
        ]);

        // Evita chamar novamente
    if ($pacienteDia->chamado_painel) {
        return response()->json(['success' => false, 'message' => 'Paciente já chamado']);
    }

    // Atualiza o campo chamado_painel
    $pacienteDia->update([
        'chamado_painel' => true
    ]);
     

        event(new PacienteChamado($pacienteDia));


        logger()->info('EVENTO DISPARADO', [
            'paciente' => $pacienteDia->id
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




   
    

    

    

