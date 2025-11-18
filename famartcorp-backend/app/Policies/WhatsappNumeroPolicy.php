<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WhatsappNumero;
use Illuminate\Auth\Access\Response;

class WhatsappNumeroPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos podem listar números WhatsApp
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WhatsappNumero $whatsappNumero): bool
    {
        // Master vê todos
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor vê apenas da sua equipe
        if ($user->cargo === 'gestor') {
            return $user->equipe_id === $whatsappNumero->equipe_id;
        }

        // Consultor vê apenas os seus e da sua equipe
        return $user->id === $whatsappNumero->consultor_id || $user->equipe_id === $whatsappNumero->equipe_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Master e gestor podem criar números
        return in_array($user->cargo, ['master', 'gestor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WhatsappNumero $whatsappNumero): bool
    {
        // Master pode atualizar todos
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor pode atualizar apenas da sua equipe
        if ($user->cargo === 'gestor') {
            return $user->equipe_id === $whatsappNumero->equipe_id;
        }

        // Consultor pode atualizar apenas os seus (principalmente o status)
        return $user->id === $whatsappNumero->consultor_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WhatsappNumero $whatsappNumero): bool
    {
        // Master pode deletar todos
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor pode deletar apenas da sua equipe
        return $user->cargo === 'gestor' && $user->equipe_id === $whatsappNumero->equipe_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WhatsappNumero $whatsappNumero): bool
    {
        return $user->cargo === 'master';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WhatsappNumero $whatsappNumero): bool
    {
        return $user->cargo === 'master';
    }
}
