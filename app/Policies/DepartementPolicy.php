<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Departement;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the departement can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list departements');
    }

    /**
     * Determine whether the departement can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Departement  $model
     * @return mixed
     */
    public function view(User $user, Departement $model)
    {
        return $user->hasPermissionTo('view departements');
    }

    /**
     * Determine whether the departement can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create departements');
    }

    /**
     * Determine whether the departement can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Departement  $model
     * @return mixed
     */
    public function update(User $user, Departement $model)
    {
        return $user->hasPermissionTo('update departements');
    }

    /**
     * Determine whether the departement can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Departement  $model
     * @return mixed
     */
    public function delete(User $user, Departement $model)
    {
        return $user->hasPermissionTo('delete departements');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Departement  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete departements');
    }

    /**
     * Determine whether the departement can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Departement  $model
     * @return mixed
     */
    public function restore(User $user, Departement $model)
    {
        return false;
    }

    /**
     * Determine whether the departement can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Departement  $model
     * @return mixed
     */
    public function forceDelete(User $user, Departement $model)
    {
        return false;
    }
}
