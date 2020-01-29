<?php

namespace App;

use App\Traits\LogsTrait;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    const OBJECT_CODE = 'invoices';

    protected $fillable = [
        'number'
    ];

    use LogsTrait;

    /*
     *
     *  Связи
     *
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    /* Связи (х) */

    /*
     *
     *  Прочее
     *
     */

    public function updatePrice()
    {
        $this->price = $this->orders()->sum('price_D');
        $this->save();
    }
}
