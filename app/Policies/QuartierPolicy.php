<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quartier;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuartierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the quartier can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list quartiers');
    }

    /**
     * Determine whether the quartier can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quartier  $model
     * @return mixed
     */
    public function view(User $user, Quartier $model)
    {
        return $user->hasPermissionTo('view quartiers');
    }

    /**
     * Determine whether the quartier can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create quartiers');
    }

    /**
     * Determine whether the quartier can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quartier  $model
     * @return mixed
     */
    public function update(User $user, Quartier $model)
    {
        return $user->hasPermissionTo('update quartiers');
    }

    /**
     * Determine whether the quartier can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quartier  $model
     * @return mixed
     */
    public function delete(User $user, Quartier $model)
    {
        return $user->hasPermissionTo('delete quartiers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quartier  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete quartiers');
    }

    /**
     * Determine whether the quartier can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quartier  $model
     * @return mixed
     */
    public function restore(User $user, Quartier $model)
    {
        return false;
    }

    /**
     * Determine whether the quartier can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Quartier  $model
     * @return mixed
     */
    public function forceDelete(User $user, Quartier $model)
    {
        return false;
    }
}
