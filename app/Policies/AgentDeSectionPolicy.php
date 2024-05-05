<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AgentDeSection;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgentDeSectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the agentDeSection can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list agentdesections');
    }

    /**
     * Determine whether the agentDeSection can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDeSection  $model
     * @return mixed
     */
    public function view(User $user, AgentDeSection $model)
    {
        return $user->hasPermissionTo('view agentdesections');
    }

    /**
     * Determine whether the agentDeSection can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create agentdesections');
    }

    /**
     * Determine whether the agentDeSection can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDeSection  $model
     * @return mixed
     */
    public function update(User $user, AgentDeSection $model)
    {
        return $user->hasPermissionTo('update agentdesections');
    }

    /**
     * Determine whether the agentDeSection can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDeSection  $model
     * @return mixed
     */
    public function delete(User $user, AgentDeSection $model)
    {
        return $user->hasPermissionTo('delete agentdesections');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDeSection  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete agentdesections');
    }

    /**
     * Determine whether the agentDeSection can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDeSection  $model
     * @return mixed
     */
    public function restore(User $user, AgentDeSection $model)
    {
        return false;
    }

    /**
     * Determine whether the agentDeSection can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentDeSection  $model
     * @return mixed
     */
    public function forceDelete(User $user, AgentDeSection $model)
    {
        return false;
    }
}
