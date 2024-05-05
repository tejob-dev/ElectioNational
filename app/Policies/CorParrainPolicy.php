<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CorParrain;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorParrainPolicy
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
        return $user->hasPermissionTo('list corparrains');
    }

    /**
     * Determine whether the corParrain can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CorParrain  $model
     * @return mixed
     */
    public function view(User $user, CorParrain $model)
    {
        return $user->hasPermissionTo('view corparrains');
    }

    /**
     * Determine whether the corParrain can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create corparrains');
    }

    /**
     * Determine whether the corParrain can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CorParrain  $model
     * @return mixed
     */
    public function update(User $user, CorParrain $model)
    {
        return $user->hasPermissionTo('update corparrains');
    }

    /**
     * Determine whether the corParrain can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CorParrain  $model
     * @return mixed
     */
    public function delete(User $user, CorParrain $model)
    {
        return $user->hasPermissionTo('delete corparrains');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CorParrain  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete corparrains');
    }

    /**
     * Determine whether the corParrain can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CorParrain  $model
     * @return mixed
     */
    public function restore(User $user, CorParrain $model)
    {
        return false;
    }

    /**
     * Determine whether the corParrain can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CorParrain  $model
     * @return mixed
     */
    public function forceDelete(User $user, CorParrain $model)
    {
        return false;
    }
}
