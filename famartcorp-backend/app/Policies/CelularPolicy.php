<?php

namespace App\Policies;

use App\Models\Celular;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CelularPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos podem listar celulares
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Celular $celular): bool
    {
        // Master vê todos
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor vê apenas da sua equipe
        if ($user->cargo === 'gestor') {
            return $user->equipe_id === $celular->equipe_id;
        }

        // Consultor vê apenas os seus e da sua equipe
        return $user->id === $celular->consultor_id || $user->equipe_id === $celular->equipe_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Master e gestor podem criar celulares
        return in_array($user->cargo, ['master', 'gestor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Celular $celular): bool
    {
        // Master pode atualizar todos
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor pode atualizar apenas da sua equipe
        if ($user->cargo === 'gestor') {
            return $user->equipe_id === $celular->equipe_id;
        }

        // Consultor pode atualizar apenas os seus
        return $user->id === $celular->consultor_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Celular $celular): bool
    {
        // Master pode deletar todos
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor pode deletar apenas da sua equipe
        return $user->cargo === 'gestor' && $user->equipe_id === $celular->equipe_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Celular $celular): bool
    {
        return $user->cargo === 'master';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Celular $celular): bool
    {
        return $user->cargo === 'master';
    }
}
