<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    /**
     * Modelo Equipe
     *
     * Representa uma equipe comercial (ex.: Equipe Alfa).
     * Campos principais: id, nome, gestor_id, timestamps.
     * Relações:
     * - possui um `gestor` (User)
     * - possui muitos `consultores` (users com equipe_id)
     * - possui muitos `celulares`
     *
     * Uso: utilizado para filtrar dados por equipe e atribuir gestores.
     */
    protected $table = 'equipes';

    protected $fillable = [
        'nome',
        'gestor_id',
    ];

    // Relacionamentos
    public function gestor()
    {
        return $this->belongsTo(User::class, 'gestor_id');
    }

    public function consultores()
    {
        return $this->hasMany(User::class, 'equipe_id');
    }

    public function celulares()
    {
        return $this->hasMany(Celular::class, 'equipe_id');
    }
}
