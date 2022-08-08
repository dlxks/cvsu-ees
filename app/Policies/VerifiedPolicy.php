<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Verified;
use Illuminate\Auth\Access\HandlesAuthorization;

class VerifiedPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->hasRole('personnel')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        if ($user->hasRole('personnel') || $user->hasRole('applicant')){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->hasRole('personnel') || $user->hasRole('applicant')){
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        if ($user->hasRole('personnel') || $user->hasRole('applicant')){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        if ($user->hasRole('personnel')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Verified $verified)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Verified $verified)
    {
    }
}
