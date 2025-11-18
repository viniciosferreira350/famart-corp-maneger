<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappNumero extends Model
{
    /**
     * Modelo WhatsappNumero
     *
     * Representa um número de WhatsApp vinculado a um celular corporativo.
     * Campos principais: id, numero, status, celular_id, consultor_id, equipe_id, timestamps.
     * status: enum('ativo','restrito','banido','banido_permanente','emprestado')
     *
     * Relações:
     * - pertence a um `celular`
     * - pertence a um `consultor` (User)
     * - pertence a uma `equipe`
     */
    protected $table = 'whatsapp_numeros';

    protected $fillable = [
        'numero',
        'status',
        'celular_id',
        'consultor_id',
        'equipe_id',
    ];

    public function celular()
    {
        return $this->belongsTo(Celular::class, 'celular_id');
    }

    public function consultor()
    {
        return $this->belongsTo(User::class, 'consultor_id');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'equipe_id');
    }
}
