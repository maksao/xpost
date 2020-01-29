<?php

namespace App\Policies;

use App\OrderTrack;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderTrackPolicy
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

    public function delete(User $user, OrderTrack $track)
    {
        if(is_null($track->e_received_at) && is_null($track->c_received_at)){
            return true;
        }
    }
}
