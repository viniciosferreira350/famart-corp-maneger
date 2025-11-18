<?php

namespace App\Policies;

use App\Models\Equipe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos podem ver equipes
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equipe $equipe): bool
    {
        // Master vê todas
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor e consultor veem apenas sua equipe
        return $user->equipe_id === $equipe->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Apenas master pode criar equipes
        return $user->cargo === 'master';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipe $equipe): bool
    {
        // Master pode atualizar todas
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor pode atualizar apenas sua equipe
        return $user->cargo === 'gestor' && $user->equipe_id === $equipe->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Equipe $equipe): bool
    {
        // Apenas master pode deletar equipes
        return $user->cargo === 'master';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Equipe $equipe): bool
    {
        return $user->cargo === 'master';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Equipe $equipe): bool
    {
        return $user->cargo === 'master';
    }
}
