<?php

namespace App\Policies;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChallengePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Challenge  $challenge
     * @return mixed
     */
    public function view(User $user, Challenge $challenge)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Challenge  $challenge
     * @return mixed
     */
    public function update(User $user, Challenge $challenge)
    {
        return $user->id == $challenge->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Challenge  $challenge
     * @return mixed
     */
    public function delete(User $user, Challenge $challenge)
    {
        return $user->id == $challenge->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Challenge  $challenge
     * @return mixed
     */
    public function restore(User $user, Challenge $challenge)
    {
        return $user->id == $challenge->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Challenge  $challenge
     * @return mixed
     */
    public function forceDelete(User $user, Challenge $challenge)
    {
        return $user->id == $challenge->user_id;
    }
}
