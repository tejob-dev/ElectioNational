<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LieuVote;
use Illuminate\Auth\Access\HandlesAuthorization;

class LieuVotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the lieuVote can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list lieuvotes');
    }

    /**
     * Determine whether the lieuVote can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LieuVote  $model
     * @return mixed
     */
    public function view(User $user, LieuVote $model)
    {
        return $user->hasPermissionTo('view lieuvotes');
    }

    /**
     * Determine whether the lieuVote can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create lieuvotes');
    }

    /**
     * Determine whether the lieuVote can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LieuVote  $model
     * @return mixed
     */
    public function update(User $user, LieuVote $model)
    {
        return $user->hasPermissionTo('update lieuvotes');
    }

    /**
     * Determine whether the lieuVote can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LieuVote  $model
     * @return mixed
     */
    public function delete(User $user, LieuVote $model)
    {
        return $user->hasPermissionTo('delete lieuvotes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LieuVote  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete lieuvotes');
    }

    /**
     * Determine whether the lieuVote can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LieuVote  $model
     * @return mixed
     */
    public function restore(User $user, LieuVote $model)
    {
        return false;
    }

    /**
     * Determine whether the lieuVote can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\LieuVote  $model
     * @return mixed
     */
    public function forceDelete(User $user, LieuVote $model)
    {
        return false;
    }
}
