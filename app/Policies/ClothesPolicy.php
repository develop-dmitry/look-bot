<?php

namespace App\Policies;

use App\Models\Clothes;
use App\Models\User;

class ClothesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view clothes');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Clothes $clothes): bool
    {
        return $user->can('view clothes');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create clothes');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Clothes $clothes): bool
    {
        return $user->can('update clothes');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Clothes $clothes): bool
    {
        return $user->can('delete clothes');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Clothes $clothes): bool
    {
        return $user->can('create clothes');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Clothes $clothes): bool
    {
        return $user->can('delete clothes');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete clothes');
    }
}
