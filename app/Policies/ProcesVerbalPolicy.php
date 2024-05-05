<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProcesVerbal;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProcesVerbalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the procesVerbal can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list procesverbals');
    }

    /**
     * Determine whether the procesVerbal can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProcesVerbal  $model
     * @return mixed
     */
    public function view(User $user, ProcesVerbal $model)
    {
        return $user->hasPermissionTo('view procesverbals');
    }

    /**
     * Determine whether the procesVerbal can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create procesverbals');
    }

    /**
     * Determine whether the procesVerbal can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProcesVerbal  $model
     * @return mixed
     */
    public function update(User $user, ProcesVerbal $model)
    {
        return $user->hasPermissionTo('update procesverbals');
    }

    /**
     * Determine whether the procesVerbal can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProcesVerbal  $model
     * @return mixed
     */
    public function delete(User $user, ProcesVerbal $model)
    {
        return $user->hasPermissionTo('delete procesverbals');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProcesVerbal  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete procesverbals');
    }

    /**
     * Determine whether the procesVerbal can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProcesVerbal  $model
     * @return mixed
     */
    public function restore(User $user, ProcesVerbal $model)
    {
        return false;
    }

    /**
     * Determine whether the procesVerbal can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProcesVerbal  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProcesVerbal $model)
    {
        return false;
    }
}
