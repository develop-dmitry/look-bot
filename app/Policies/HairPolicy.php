<?php

namespace App\Policies;

use App\Models\Hair;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HairPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view hair');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hair $hair): bool
    {
        return $user->can('view hair');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create hair');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hair $hair): bool
    {
        return $user->can('update hair');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hair $hair): bool
    {
        return $user->can('delete hair');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Hair $hair): bool
    {
        return $user->can('delete hair');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Hair $hair): bool
    {
        return $user->can('delete hair');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete hair');
    }
}
