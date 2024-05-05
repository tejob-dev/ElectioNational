<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Parrain;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParrainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the parrain can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list parrains');
    }

    /**
     * Determine whether the parrain can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parrain  $model
     * @return mixed
     */
    public function view(User $user, Parrain $model)
    {
        return $user->hasPermissionTo('view parrains');
    }

    /**
     * Determine whether the parrain can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create parrains');
    }

    /**
     * Determine whether the parrain can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parrain  $model
     * @return mixed
     */
    public function update(User $user, Parrain $model)
    {
        return $user->hasPermissionTo('update parrains');
    }

    /**
     * Determine whether the parrain can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parrain  $model
     * @return mixed
     */
    public function delete(User $user, Parrain $model)
    {
        return $user->hasPermissionTo('delete parrains');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parrain  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete parrains');
    }

    /**
     * Determine whether the parrain can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parrain  $model
     * @return mixed
     */
    public function restore(User $user, Parrain $model)
    {
        return false;
    }

    /**
     * Determine whether the parrain can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parrain  $model
     * @return mixed
     */
    public function forceDelete(User $user, Parrain $model)
    {
        return false;
    }
}
