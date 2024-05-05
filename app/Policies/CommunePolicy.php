<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Commune;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommunePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the commune can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list communes');
    }

    /**
     * Determine whether the commune can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Commune  $model
     * @return mixed
     */
    public function view(User $user, Commune $model)
    {
        return $user->hasPermissionTo('view communes');
    }

    /**
     * Determine whether the commune can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create communes');
    }

    /**
     * Determine whether the commune can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Commune  $model
     * @return mixed
     */
    public function update(User $user, Commune $model)
    {
        return $user->hasPermissionTo('update communes');
    }

    /**
     * Determine whether the commune can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Commune  $model
     * @return mixed
     */
    public function delete(User $user, Commune $model)
    {
        return $user->hasPermissionTo('delete communes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Commune  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete communes');
    }

    /**
     * Determine whether the commune can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Commune  $model
     * @return mixed
     */
    public function restore(User $user, Commune $model)
    {
        return false;
    }

    /**
     * Determine whether the commune can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Commune  $model
     * @return mixed
     */
    public function forceDelete(User $user, Commune $model)
    {
        return false;
    }
}
