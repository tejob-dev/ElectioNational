<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SousSection;
use Illuminate\Auth\Access\HandlesAuthorization;

class SousSectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sousSection can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list soussections');
    }

    /**
     * Determine whether the sousSection can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SousSection  $model
     * @return mixed
     */
    public function view(User $user, SousSection $model)
    {
        return $user->hasPermissionTo('view soussections');
    }

    /**
     * Determine whether the sousSection can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create soussections');
    }

    /**
     * Determine whether the sousSection can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SousSection  $model
     * @return mixed
     */
    public function update(User $user, SousSection $model)
    {
        return $user->hasPermissionTo('update soussections');
    }

    /**
     * Determine whether the sousSection can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SousSection  $model
     * @return mixed
     */
    public function delete(User $user, SousSection $model)
    {
        return $user->hasPermissionTo('delete soussections');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SousSection  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete soussections');
    }

    /**
     * Determine whether the sousSection can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SousSection  $model
     * @return mixed
     */
    public function restore(User $user, SousSection $model)
    {
        return false;
    }

    /**
     * Determine whether the sousSection can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SousSection  $model
     * @return mixed
     */
    public function forceDelete(User $user, SousSection $model)
    {
        return false;
    }
}
