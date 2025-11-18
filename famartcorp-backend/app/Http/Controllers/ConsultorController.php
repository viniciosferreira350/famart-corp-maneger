<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class ConsultorController extends Controller
{
    /**
     * Listar consultores.
     *
     * Comentário: retorna todos os usuários com cargo 'consultor'.
     * Aceita filtro opcional `equipe_id` via query string para limitar por equipe.
     */
    public function index(Request $request): JsonResponse
    {
        // Query básica filtrando por cargo
        $query = User::where('cargo', 'consultor');

        // Filtro por equipe, se fornecido
        if ($request->has('equipe_id')) {
            $query->where('equipe_id', $request->query('equipe_id'));
        }

        // Carregar relacionamento com equipe para cada consultor
        $consultores = $query->with('equipe')->get();

        return response()->json($consultores, 200);
    }

    /**
     * Criar novo consultor.
     *
     * Comentário: valida os campos necessários, cria o usuário com cargo 'consultor'
     * e aplica hash na senha antes de salvar.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'equipe_id' => 'nullable|exists:equipes,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'cargo' => 'consultor',
            'equipe_id' => $validated['equipe_id'] ?? null,
        ]);

        return response()->json(['message' => 'Consultor criado com sucesso', 'data' => $user], 201);
    }

    /**
     * Exibir consultor específico.
     *
     * Comentário: busca apenas usuários com cargo 'consultor' e carrega celulares e números.
     */
    public function show(string $id): JsonResponse
    {
        $consultor = User::with(['equipe', 'celulares', 'whatsappNumeros'])
            ->where('cargo', 'consultor')
            ->find($id);

        if (!$consultor) {
            return response()->json(['message' => 'Consultor não encontrado'], 404);
        }

        return response()->json($consultor, 200);
    }

    /**
     * Atualizar consultor.
     *
     * Comentário: permite atualizar nome, email, senha e equipe. Se senha for enviada,
     * ela será re-hashada. Validações garantem unicidade de email.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $consultor = User::where('cargo', 'consultor')->find($id);

        if (!$consultor) {
            return response()->json(['message' => 'Consultor não encontrado'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:users,email,' . $consultor->id,
            'password' => 'sometimes|string|min:6',
            'equipe_id' => 'nullable|exists:equipes,id',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $consultor->update($validated);

        return response()->json(['message' => 'Consultor atualizado com sucesso', 'data' => $consultor], 200);
    }

    /**
     * Deletar consultor.
     *
     * Comentário: atualmente realiza delete hard; considerar soft deletes se necessário.
     */
    public function destroy(string $id): JsonResponse
    {
        $consultor = User::where('cargo', 'consultor')->find($id);

        if (!$consultor) {
            return response()->json(['message' => 'Consultor não encontrado'], 404);
        }

        $consultor->delete();

        return response()->json(['message' => 'Consultor deletado com sucesso'], 200);
    }
}
