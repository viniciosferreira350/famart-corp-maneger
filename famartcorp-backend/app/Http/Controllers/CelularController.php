<?php

namespace App\Http\Controllers;

use App\Models\Celular;
use Illuminate\Http\Request;

class CelularController extends Controller
{
    /**
     * Listar todos os celulares.
     */
    public function index()
    {
        $celulares = Celular::with(['consultor', 'equipe', 'whatsappNumeros'])->get();
        return response()->json($celulares, 200);
    }

    /**
     * Criar um novo celular.
     */
    public function store(Request $request)
    {
        // Validação dos campos obrigatórios
        $validated = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'imei' => 'required|string|unique:celulares,imei',
            'observacao' => 'nullable|string',
            'consultor_id' => 'nullable|exists:users,id',
            'equipe_id' => 'nullable|exists:equipes,id',
        ]);

        $celular = Celular::create($validated);

        return response()->json([
            'message' => 'Celular criado com sucesso!',
            'data' => $celular
        ], 201);
    }

    /**
     * Exibir um celular específico.
     */
    public function show($id)
    {
        $celular = Celular::with(['consultor', 'equipe', 'whatsappNumeros'])->find($id);

        if (!$celular) {
            return response()->json(['message' => 'Celular não encontrado.'], 404);
        }

        return response()->json($celular, 200);
    }

    /**
     * Atualizar um celular existente.
     */
    public function update(Request $request, $id)
    {
        $celular = Celular::find($id);

        if (!$celular) {
            return response()->json(['message' => 'Celular não encontrado.'], 404);
        }

        $validated = $request->validate([
            'marca' => 'sometimes|string|max:255',
            'modelo' => 'sometimes|string|max:255',
            'imei' => 'sometimes|string|unique:celulares,imei,' . $celular->id,
            'observacao' => 'nullable|string',
            'consultor_id' => 'nullable|exists:users,id',
            'equipe_id' => 'nullable|exists:equipes,id',
        ]);

        $celular->update($validated);

        return response()->json([
            'message' => 'Celular atualizado com sucesso!',
            'data' => $celular
        ], 200);
    }

    /**
     * Deletar um celular.
     */
    public function destroy($id)
    {
        $celular = Celular::find($id);

        if (!$celular) {
            return response()->json(['message' => 'Celular não encontrado.'], 404);
        }

        $celular->delete();

        return response()->json(['message' => 'Celular deletado com sucesso!'], 200);
    }
}
