<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BureauVote;
use Illuminate\Auth\Access\HandlesAuthorization;

class BureauVotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the bureauVote can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list bureauvotes');
    }

    /**
     * Determine whether the bureauVote can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BureauVote  $model
     * @return mixed
     */
    public function view(User $user, BureauVote $model)
    {
        return $user->hasPermissionTo('view bureauvotes');
    }

    /**
     * Determine whether the bureauVote can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create bureauvotes');
    }

    /**
     * Determine whether the bureauVote can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BureauVote  $model
     * @return mixed
     */
    public function update(User $user, BureauVote $model)
    {
        return $user->hasPermissionTo('update bureauvotes');
    }

    /**
     * Determine whether the bureauVote can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BureauVote  $model
     * @return mixed
     */
    public function delete(User $user, BureauVote $model)
    {
        return $user->hasPermissionTo('delete bureauvotes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BureauVote  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete bureauvotes');
    }

    /**
     * Determine whether the bureauVote can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BureauVote  $model
     * @return mixed
     */
    public function restore(User $user, BureauVote $model)
    {
        return false;
    }

    /**
     * Determine whether the bureauVote can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BureauVote  $model
     * @return mixed
     */
    public function forceDelete(User $user, BureauVote $model)
    {
        return false;
    }
}
