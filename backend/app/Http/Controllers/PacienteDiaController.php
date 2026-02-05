<?php

namespace App\Http\Controllers;

use App\Models\PacienteDia;
use Illuminate\Http\Request;

class PacienteDiaController extends Controller
{
    /**
     * Lista pacientes do dia (por sala / turno)
     */
    public function index(Request $request)
    {
        $pacientes = PacienteDia::with('paciente')
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('sala_dia')
            ->orderBy('created_at')
            ->get();

        return response()->json($pacientes);
    }

    /**
     * Cadastra paciente fixo
     */
    public function storePaciente(Request $request)
    {
        $data = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'dias_semana'   => 'required|integer',
            'turno'         => 'required|integer',
            'sala'          => 'required|integer',
        ]);

        $paciente = Paciente::create($data);

        return response()->json($paciente, 201);
    }

    /**
     * Adiciona paciente ao dia
     */
    public function storePacienteDia(Request $request)
    {
        $data = $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'sala_dia'    => 'required|integer',
            'turno_dia'   => 'required|integer',
        ]);

        $jaExisteHoje = PacienteDia::where('paciente_id', $data['paciente_id'])
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if ($jaExisteHoje) {
            return response()->json([
                'message' => 'Paciente já cadastrado hoje'
            ], 422);
        }

        $pacienteDia = PacienteDia::create([
            'paciente_id' => $data['paciente_id'],
            'sala_dia'    => $data['sala_dia'],
            'turno_dia'   => $data['turno_dia'],
            'chegou'      => true,
            'chamado'     => false,
            'chamado_painel' => false,
        ]);

        return response()->json($pacienteDia, 201);
    }

    /**
     * Atualizações rápidas (chegou, chamado, troca sala)
     */
    public function update(Request $request, $id)
    {
        $pacienteDia = PacienteDia::findOrFail($id);

        $data = $request->validate([
            'chegou'               => 'sometimes|boolean',
            'chamado'              => 'sometimes|boolean',
            'sala_dia'             => 'sometimes|integer',
            'turno_dia'            => 'sometimes|integer',
            'observacao'           => 'nullable|string',
            'chamado_painel'       => 'sometimes|boolean',
            'chamar_acompanhante'  => 'sometimes|boolean',
        ]);

        $pacienteDia->update($data);

        return response()->json($pacienteDia);
    }

    /**
     * Chamar novamente (voz / painel)
     */
    public function chamarNovamente($id)
    {
        $pacienteDia = PacienteDia::findOrFail($id);

        $pacienteDia->update([
            'chamado' => true,
            'chamado_painel' => true,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Chamar acompanhante
     */
    public function chamarAcompanhante($id)
    {
        $pacienteDia = PacienteDia::findOrFail($id);

        $pacienteDia->update([
            'chamar_acompanhante' => true,
            'chamado_painel' => true,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove paciente do dia
     */
    public function destroy($id)
    {
        PacienteDia::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}
