<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AgentTerrain;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgentTerrainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the agentTerrain can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list agentterrains');
    }

    /**
     * Determine whether the agentTerrain can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentTerrain  $model
     * @return mixed
     */
    public function view(User $user, AgentTerrain $model)
    {
        return $user->hasPermissionTo('view agentterrains');
    }

    /**
     * Determine whether the agentTerrain can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create agentterrains');
    }

    /**
     * Determine whether the agentTerrain can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentTerrain  $model
     * @return mixed
     */
    public function update(User $user, AgentTerrain $model)
    {
        return $user->hasPermissionTo('update agentterrains');
    }

    /**
     * Determine whether the agentTerrain can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentTerrain  $model
     * @return mixed
     */
    public function delete(User $user, AgentTerrain $model)
    {
        return $user->hasPermissionTo('delete agentterrains');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentTerrain  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete agentterrains');
    }

    /**
     * Determine whether the agentTerrain can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentTerrain  $model
     * @return mixed
     */
    public function restore(User $user, AgentTerrain $model)
    {
        return false;
    }

    /**
     * Determine whether the agentTerrain can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AgentTerrain  $model
     * @return mixed
     */
    public function forceDelete(User $user, AgentTerrain $model)
    {
        return false;
    }
}
