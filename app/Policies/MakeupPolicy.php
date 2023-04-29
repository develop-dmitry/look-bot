<?php

namespace App\Policies;

use App\Models\Makeup;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MakeupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view makeup');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Makeup $makeup): bool
    {
        return $user->can('view makeup');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create makeup');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Makeup $makeup): bool
    {
        return $user->can('update makeup');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Makeup $makeup): bool
    {
        return $user->can('delete makeup');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Makeup $makeup): bool
    {
        return $user->can('delete makeup');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Makeup $makeup): bool
    {
        return $user->can('delete makeup');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete makeup');
    }
}
