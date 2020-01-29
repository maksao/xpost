<?php

namespace App;

use App\Traits\LogsTrait;
use Illuminate\Database\Eloquent\Model;

class OrderTrack extends Model
{
    protected $fillable = [
        'number',
        'order_id',
        'delivery_service_id',
        'e_received_at',
        'c_received_at'
    ];

    protected $dates = [
        'e_received_at',
        'c_received_at'
    ];

    use LogsTrait;

    /*
     *
     *  Связи
     *
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function delivery_service()
    {
        return $this->belongsTo(DeliveryService::class)->withDefault(['name'=>'отсутствует']);
    }
    /* Связи (х) */

}
