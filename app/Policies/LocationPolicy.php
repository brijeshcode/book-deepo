<?php

namespace App\Policies;

use App\Models\Setup\Location;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // dd('vue anyt');
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setup\Location  $location
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return true;
        dd('test');
        //
         return $user->id === $location->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setup\Location  $location
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setup\Location  $location
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setup\Location  $location
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setup\Location  $location
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Location $location)
    {
        //
    }
}
