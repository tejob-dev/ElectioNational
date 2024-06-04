<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ElectorParrain;
use Illuminate\Auth\Access\HandlesAuthorization;

class ElectorParrainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the corParrain can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list electorparrains');
    }

    /**
     * Determine whether the corParrain can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ElectorParrain  $model
     * @return mixed
     */
    public function view(User $user, ElectorParrain $model)
    {
        return $user->hasPermissionTo('view electorparrains');
    }

    /**
     * Determine whether the corParrain can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create electorparrains');
    }

    /**
     * Determine whether the corParrain can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ElectorParrain  $model
     * @return mixed
     */
    public function update(User $user, ElectorParrain $model)
    {
        return $user->hasPermissionTo('update electorparrains');
    }

    /**
     * Determine whether the corParrain can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ElectorParrain  $model
     * @return mixed
     */
    public function delete(User $user, ElectorParrain $model)
    {
        return $user->hasPermissionTo('delete electorparrains');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ElectorParrain  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete electorparrains');
    }

    /**
     * Determine whether the corParrain can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ElectorParrain  $model
     * @return mixed
     */
    public function restore(User $user, ElectorParrain $model)
    {
        return false;
    }

    /**
     * Determine whether the corParrain can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ElectorParrain  $model
     * @return mixed
     */
    public function forceDelete(User $user, ElectorParrain $model)
    {
        return false;
    }
}
