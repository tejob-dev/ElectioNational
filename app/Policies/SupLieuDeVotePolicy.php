<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SupLieuDeVote;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupLieuDeVotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the supLieuDeVote can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list suplieudevotes');
    }

    /**
     * Determine whether the supLieuDeVote can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupLieuDeVote  $model
     * @return mixed
     */
    public function view(User $user, SupLieuDeVote $model)
    {
        return $user->hasPermissionTo('view suplieudevotes');
    }

    /**
     * Determine whether the supLieuDeVote can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create suplieudevotes');
    }

    /**
     * Determine whether the supLieuDeVote can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupLieuDeVote  $model
     * @return mixed
     */
    public function update(User $user, SupLieuDeVote $model)
    {
        return $user->hasPermissionTo('update suplieudevotes');
    }

    /**
     * Determine whether the supLieuDeVote can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupLieuDeVote  $model
     * @return mixed
     */
    public function delete(User $user, SupLieuDeVote $model)
    {
        return $user->hasPermissionTo('delete suplieudevotes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupLieuDeVote  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete suplieudevotes');
    }

    /**
     * Determine whether the supLieuDeVote can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupLieuDeVote  $model
     * @return mixed
     */
    public function restore(User $user, SupLieuDeVote $model)
    {
        return false;
    }

    /**
     * Determine whether the supLieuDeVote can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SupLieuDeVote  $model
     * @return mixed
     */
    public function forceDelete(User $user, SupLieuDeVote $model)
    {
        return false;
    }
}
