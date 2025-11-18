<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    /**
     * Listar todas as equipes.
     */
    public function index()
    {
        $equipes = Equipe::with(['gestor', 'consultores', 'celulares'])->get();
        return response()->json($equipes, 200);
    }

    /**
     * Criar uma nova equipe.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:equipes,nome',
            'gestor_id' => 'nullable|exists:users,id',
        ]);

        $equipe = Equipe::create($validated);

        return response()->json([
            'message' => 'Equipe criada com sucesso!',
            'data' => $equipe
        ], 201);
    }

    /**
     * Exibir uma equipe específica.
     */
    public function show($id)
    {
        $equipe = Equipe::with(['gestor', 'consultores', 'celulares'])->find($id);

        if (!$equipe) {
            return response()->json(['message' => 'Equipe não encontrada.'], 404);
        }

        return response()->json($equipe, 200);
    }

    /**
     * Atualizar uma equipe existente.
     */
    public function update(Request $request, $id)
    {
        $equipe = Equipe::find($id);

        if (!$equipe) {
            return response()->json(['message' => 'Equipe não encontrada.'], 404);
        }

        $validated = $request->validate([
            'nome' => 'sometimes|string|max:100|unique:equipes,nome,' . $equipe->id,
            'gestor_id' => 'nullable|exists:users,id',
        ]);

        $equipe->update($validated);

        return response()->json([
            'message' => 'Equipe atualizada com sucesso!',
            'data' => $equipe
        ], 200);
    }

    /**
     * Excluir uma equipe.
     */
    public function destroy($id)
    {
        $equipe = Equipe::find($id);

        if (!$equipe) {
            return response()->json(['message' => 'Equipe não encontrada.'], 404);
        }

        $equipe->delete();

        return response()->json(['message' => 'Equipe deletada com sucesso!'], 200);
    }
}
