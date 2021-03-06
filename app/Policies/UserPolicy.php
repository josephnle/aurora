<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

	public function before($user, $ability)
	{
		if ($user->admin) {
			return true;
		}
	}

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $userObj
     * @return mixed
     */
    public function view(User $user, User $userObj)
    {
        //
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
    	return $user->admin;
    }

	/**
	 * Determine whether the user can update the user.
	 *
	 * @param \App\User $user
	 * @param \App\User $userObj
	 * @return mixed
	 */
    public function update(User $user, User $userObj)
    {
	    return $userObj->id === \Auth::id();
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $userObj
     * @return mixed
     */
    public function delete(User $user, User $userObj)
    {
        return $user->admin;
    }
}
