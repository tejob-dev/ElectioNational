<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rabatteur;
use Illuminate\Auth\Access\HandlesAuthorization;

class RabatteurPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the rabatteur can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list rabatteurs');
    }

    /**
     * Determine whether the rabatteur can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rabatteur  $model
     * @return mixed
     */
    public function view(User $user, Rabatteur $model)
    {
        return $user->hasPermissionTo('view rabatteurs');
    }

    /**
     * Determine whether the rabatteur can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create rabatteurs');
    }

    /**
     * Determine whether the rabatteur can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rabatteur  $model
     * @return mixed
     */
    public function update(User $user, Rabatteur $model)
    {
        return $user->hasPermissionTo('update rabatteurs');
    }

    /**
     * Determine whether the rabatteur can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rabatteur  $model
     * @return mixed
     */
    public function delete(User $user, Rabatteur $model)
    {
        return $user->hasPermissionTo('delete rabatteurs');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rabatteur  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete rabatteurs');
    }

    /**
     * Determine whether the rabatteur can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rabatteur  $model
     * @return mixed
     */
    public function restore(User $user, Rabatteur $model)
    {
        return false;
    }

    /**
     * Determine whether the rabatteur can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Rabatteur  $model
     * @return mixed
     */
    public function forceDelete(User $user, Rabatteur $model)
    {
        return false;
    }
}
