<?php

namespace App\Policies;

use App\Pricelist;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricelistPolicy
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

    public function upload(User $user, Pricelist $pricelist)
    {
        return $pricelist->status !== 1;
    }
}
