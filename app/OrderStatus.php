<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    /*
     *
     *  Связи
     *
     */

    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }

    /* Связи (х) */

    /*
     *
     *  Скоупы
     *
     */

    // Только статусы подтвержденных заказов
    public function scopeOfConfirmed($q)
    {
        $q->where('id', '>', 1);
    }

    /* Скоупы (х) */

    /*
     *
     *  Прочее
     *
     */

}
