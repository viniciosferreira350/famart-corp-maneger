<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /**
     * Modelo User
     *
     * Representa um usuário do sistema (consultor, gestor ou master).
     * Campos principais: id, name, email, password, cargo, equipe_id, timestamps.
     * Relações:
     * - pertence a uma `equipe` (equipe_id)
     * - tem muitos `celulares` (consultor_id)
     * - tem muitos `whatsappNumeros` (consultor_id)
     *
     * Observações:
     * - Utilizamos o campo `cargo` para controle de permissões (middleware/policies).
     */
    /** @use HasFactory<\\Database\\Factories\\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cargo',
        'equipe_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relations
    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'equipe_id');
    }

    public function celulares()
    {
        return $this->hasMany(Celular::class, 'consultor_id');
    }

    public function whatsappNumeros()
    {
        return $this->hasMany(WhatsappNumero::class, 'consultor_id');
    }
}
