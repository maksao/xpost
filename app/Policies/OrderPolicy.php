<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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

    public function view(User $user, Order $order)
    {
        return $user->id == $order->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Order $order)
    {
        return true;
    }

    public function upload(User $user, Order $order)
    {
        if( $order->isStatus('prep')){
            return true;
        }
    }

    public function delete(User $user, Order $order)
    {
        if( $order->isStatus('prep')){
            return true;
        }
    }

    public function accept(User $user, Order $order)
    {
        if( $order->user_id == $user->id
            && $order->isStatus('prep')
            && $order->positions()->whereNull('product_id')->count() == 0
        ){
            return true;
        }
    }

    public function reject(User $user, Order $order)
    {
        if( $order->user_id == $user->id
            && $order->isStatus('new')
            && $order->positions()->ofStatus('new')->count() == $order->positions()->count()
        ){
            return true;
        }
    }
}
