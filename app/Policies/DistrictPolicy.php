<?php

namespace App\Policies;

use App\Models\User;
use App\Models\District;
use Illuminate\Auth\Access\HandlesAuthorization;

class DistrictPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the district can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list districts');
    }

    /**
     * Determine whether the district can view the model.
     */
    public function view(User $user, District $model): bool
    {
        return $user->hasPermissionTo('view districts');
    }

    /**
     * Determine whether the district can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create districts');
    }

    /**
     * Determine whether the district can update the model.
     */
    public function update(User $user, District $model): bool
    {
        return $user->hasPermissionTo('update districts');
    }

    /**
     * Determine whether the district can delete the model.
     */
    public function delete(User $user, District $model): bool
    {
        return $user->hasPermissionTo('delete districts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete districts');
    }

    /**
     * Determine whether the district can restore the model.
     */
    public function restore(User $user, District $model): bool
    {
        return false;
    }

    /**
     * Determine whether the district can permanently delete the model.
     */
    public function forceDelete(User $user, District $model): bool
    {
        return false;
    }
}
