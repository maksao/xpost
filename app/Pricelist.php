<?php

namespace App;

use App\Traits\LogsTrait;
use Illuminate\Database\Eloquent\Model;

class Pricelist extends Model
{

    protected $fillable = [
        'name',
        'comment',
        'status', // 0 - ок, 1 - обновление, 2 - ошибка
        'last_updated_at'
    ];

    protected $dates = ['last_updated_at'];

    use LogsTrait;

    /*
     *
     *  Связи
     *
     */

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    /* Связи (х) */

    /*
     *
     *  Прочее
     *
     */

    public function setStatus($status)
    {
        if($this->status !== $status) {
            $this->status = $status;
            $this->save();
        }
    }
}
