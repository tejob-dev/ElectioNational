<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Candidat;
use Illuminate\Auth\Access\HandlesAuthorization;

class CandidatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the candidat can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list candidats');
    }

    /**
     * Determine whether the candidat can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Candidat  $model
     * @return mixed
     */
    public function view(User $user, Candidat $model)
    {
        return $user->hasPermissionTo('view candidats');
    }

    /**
     * Determine whether the candidat can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create candidats');
    }

    /**
     * Determine whether the candidat can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Candidat  $model
     * @return mixed
     */
    public function update(User $user, Candidat $model)
    {
        return $user->hasPermissionTo('update candidats');
    }

    /**
     * Determine whether the candidat can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Candidat  $model
     * @return mixed
     */
    public function delete(User $user, Candidat $model)
    {
        return $user->hasPermissionTo('delete candidats');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Candidat  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete candidats');
    }

    /**
     * Determine whether the candidat can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Candidat  $model
     * @return mixed
     */
    public function restore(User $user, Candidat $model)
    {
        return false;
    }

    /**
     * Determine whether the candidat can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Candidat  $model
     * @return mixed
     */
    public function forceDelete(User $user, Candidat $model)
    {
        return false;
    }
}
