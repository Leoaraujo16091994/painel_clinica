<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        return response()->json(
            Paciente::orderBy('created_at', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'dias_semana'   => 'required|integer',
            'turno'         => 'required|integer',
            'sala'          => 'required|integer',
        ]);

        $paciente = Paciente::create($dados);

        return response()->json($paciente, 201);
    }

    public function show($id)
    {
        return response()->json(
            Paciente::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $dados = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'dias_semana'   => 'required|integer',
            'turno'         => 'required|integer',
            'sala'          => 'required|integer',
        ]);

        $paciente->update($dados);

        return response()->json($paciente);
    }

    public function destroy($id)
    {
        Paciente::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
