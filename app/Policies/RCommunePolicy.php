<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RCommune;
use Illuminate\Auth\Access\HandlesAuthorization;

class RCommunePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the rcommune can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list rcommunes');
    }

    /**
     * Determine whether the rcommune can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RCommune  $model
     * @return mixed
     */
    public function view(User $user, RCommune $model)
    {
        return $user->hasPermissionTo('view rcommunes');
    }

    /**
     * Determine whether the rcommune can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create rcommunes');
    }

    /**
     * Determine whether the rcommune can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RCommune  $model
     * @return mixed
     */
    public function update(User $user, RCommune $model)
    {
        return $user->hasPermissionTo('update rcommunes');
    }

    /**
     * Determine whether the rcommune can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RCommune  $model
     * @return mixed
     */
    public function delete(User $user, RCommune $model)
    {
        return $user->hasPermissionTo('delete rcommunes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RCommune  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete rcommunes');
    }

    /**
     * Determine whether the rcommune can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RCommune  $model
     * @return mixed
     */
    public function restore(User $user, RCommune $model)
    {
        return false;
    }

    /**
     * Determine whether the rcommune can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RCommune  $model
     * @return mixed
     */
    public function forceDelete(User $user, RCommune $model)
    {
        return false;
    }
}
