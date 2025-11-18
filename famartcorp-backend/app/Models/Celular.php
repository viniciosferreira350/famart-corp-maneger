<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Celular extends Model
{
    /**
     * Modelo Celular
     *
     * Representa um aparelho corporativo.
     * Campos principais: id, marca, modelo, imei, observacao, consultor_id, equipe_id.
     * Relações:
     * - pertence a um `consultor` (User)
     * - pertence a uma `equipe`
     * - possui muitos `whatsappNumeros`
     *
     * Observação: IMEI é único quando presente.
     */
    protected $table = 'celulares';

    protected $fillable = [
        'marca',
        'modelo',
        'imei',
        'observacao',
        'consultor_id',
        'equipe_id',
    ];

    public function consultor()
    {
        return $this->belongsTo(User::class, 'consultor_id');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'equipe_id');
    }

    public function whatsappNumeros()
    {
        return $this->hasMany(WhatsappNumero::class, 'celular_id');
    }
}
