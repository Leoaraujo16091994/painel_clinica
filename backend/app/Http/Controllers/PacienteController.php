<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $pacientes = [
        ['id' => 1, 'nome' => 'Leo Araujo', 'email' => 'joao@email.com', 'telefone' => '1111-1111'],
        ['id' => 2, 'nome' => 'Maria Souza', 'email' => 'maria@email.com', 'telefone' => '2222-2222'],
        ['id' => 3, 'nome' => 'Pedro Lima', 'email' => 'pedro@email.com', 'telefone' => '3333-3333']
    ];

    // Retorna JSON para o frontend
    return response()->json($pacientes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
