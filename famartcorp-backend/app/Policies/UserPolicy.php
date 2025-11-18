<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Master e gestor podem ver todos, consultor vê apenas de sua equipe
        return in_array($user->cargo, ['master', 'gestor', 'consultor']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Master vê todos
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor vê apenas sua equipe
        if ($user->cargo === 'gestor') {
            return $user->equipe_id === $model->equipe_id;
        }

        // Consultor vê apenas a si mesmo e colegas da mesma equipe
        return $user->equipe_id === $model->equipe_id || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Apenas master e gestor podem criar usuários
        return in_array($user->cargo, ['master', 'gestor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Master pode atualizar todos
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor pode atualizar apenas sua equipe
        if ($user->cargo === 'gestor') {
            return $user->equipe_id === $model->equipe_id;
        }

        // Consultor pode atualizar apenas a si mesmo
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Apenas master pode deletar
        if ($user->cargo === 'master') {
            return true;
        }

        // Gestor pode deletar apenas consultores de sua equipe
        if ($user->cargo === 'gestor') {
            return $model->cargo === 'consultor' && $user->equipe_id === $model->equipe_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->cargo === 'master';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->cargo === 'master';
    }
}
