<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AgentDuBureauVote;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgentDuBureauVotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the agentDuBureauVote can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list agentdubureauvotes');
    }

    /**
     * Determine whether the agentDuBureauVote can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDuBureauVote  $model
     * @return mixed
     */
    public function view(User $user, AgentDuBureauVote $model)
    {
        return $user->hasPermissionTo('view agentdubureauvotes');
    }

    /**
     * Determine whether the agentDuBureauVote can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create agentdubureauvotes');
    }

    /**
     * Determine whether the agentDuBureauVote can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDuBureauVote  $model
     * @return mixed
     */
    public function update(User $user, AgentDuBureauVote $model)
    {
        return $user->hasPermissionTo('update agentdubureauvotes');
    }

    /**
     * Determine whether the agentDuBureauVote can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDuBureauVote  $model
     * @return mixed
     */
    public function delete(User $user, AgentDuBureauVote $model)
    {
        return $user->hasPermissionTo('delete agentdubureauvotes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDuBureauVote  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete agentdubureauvotes');
    }

    /**
     * Determine whether the agentDuBureauVote can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDuBureauVote  $model
     * @return mixed
     */
    public function restore(User $user, AgentDuBureauVote $model)
    {
        return false;
    }

    /**
     * Determine whether the agentDuBureauVote can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDuBureauVote  $model
     * @return mixed
     */
    public function forceDelete(User $user, AgentDuBureauVote $model)
    {
        return false;
    }
}
