<?php

namespace App\Http\Controllers;

use App\Models\WhatsappNumero;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WhatsappController extends Controller
{
    /**
     * Listar números de WhatsApp com filtros e paginação.
     *
     * Aceita query params:
     * - status: filtra por status do número (ativo, restrito, etc.)
     * - equipe_id: filtra por equipe
     * - consultor_id: filtra por consultor
     * - per_page: numero de itens por página (padrão 15)
     *
     * Retorna dados paginados incluindo relações (celular, consultor, equipe) para o frontend.
     */
    public function index(Request $request): JsonResponse
    {
        $query = WhatsappNumero::query();

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->has('equipe_id')) {
            $query->where('equipe_id', $request->query('equipe_id'));
        }

        if ($request->has('consultor_id')) {
            $query->where('consultor_id', $request->query('consultor_id'));
        }

        $perPage = (int) $request->query('per_page', 15);

        $result = $query->with(['celular', 'consultor', 'equipe'])->paginate($perPage);

        return response()->json($result);
    }

    /**
     * Criar novo número de WhatsApp.
     *
     * Valida:
     * - numero (único)
     * - celular_id, consultor_id, equipe_id (existência)
     * - status (opcional, deve ser um dos valores permitidos)
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'numero' => ['required','string','max:20','unique:whatsapp_numeros,numero'],
            'celular_id' => ['required','integer','exists:celulares,id'],
            'consultor_id' => ['required','integer','exists:users,id'],
            'equipe_id' => ['required','integer','exists:equipes,id'],
            'status' => ['sometimes','in:ativo,restrito,banido,banido_permanente,emprestado'],
        ]);

        $whatsapp = WhatsappNumero::create($data);

        return response()->json($whatsapp, 201);
    }

    /**
     * Mostrar detalhe de um número de WhatsApp.
     *
     * Retorna o registro com relações para facilitar visualização no frontend.
     */
    public function show(string $id): JsonResponse
    {
        $whatsapp = WhatsappNumero::with(['celular','consultor','equipe'])->findOrFail($id);

        return response()->json($whatsapp);
    }

    /**
     * Atualizar um número de WhatsApp.
     *
     * Permite atualizar status, número e vínculos (celular/consultor/equipe).
     * Valida unicidade do número ignorando o próprio registro em atualização.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $whatsapp = WhatsappNumero::findOrFail($id);

        $data = $request->validate([
            'status' => ['sometimes','in:ativo,restrito,banido,banido_permanente,emprestado'],
            'numero' => ['sometimes','string','max:20','unique:whatsapp_numeros,numero,'.$id],
            'celular_id' => ['sometimes','integer','exists:celulares,id'],
            'consultor_id' => ['sometimes','integer','exists:users,id'],
            'equipe_id' => ['sometimes','integer','exists:equipes,id'],
        ]);

        $whatsapp->update($data);

        return response()->json($whatsapp);
    }

    /**
     * Remover um número de WhatsApp.
     *
     * Observação: atualmente realiza exclusão definitiva; considerar soft delete se
     * for necessário manter histórico de alterações.
     */
    public function destroy(string $id): JsonResponse
    {
        $whatsapp = WhatsappNumero::findOrFail($id);
        $whatsapp->delete();

        return response()->json(['deleted' => true]);
    }
}
