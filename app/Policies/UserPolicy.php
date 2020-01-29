<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function view(User $user)
    {
        return !! $user->isAdmin();
    }

    public function create(User $user, User $target)
    {
        return !! $user->isAdmin();
    }

    public function update(User $user, User $target)
    {
        return !! $user->isAdmin();
    }

    public function login_as(User $user, User $target)
    {
        return !! ( $user->isAdmin() && $user->id != $target->id );
    }
    public function return_to_account(User $user)
    {
        return !! session()->has('logged_from');
    }

}
