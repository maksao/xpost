<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPositionStatus extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    /*
     *
     *  Связи
     *
     */

    public function positions()
    {
        return $this->hasMany(OrderPosition::class, 'status_id');
    }

    /* Связи (х) */

    /*
     *
     *  Скоупы
     *
     */

    // Только статусы подтвержденных позиций

    public function scopeOfConfirmed($q)
    {
        $q->where('id', '>', 1);
    }

    public function scopeOfCode($q, $code)
    {
        $q->where('code', $code);
    }
    /* Скоупы (х) */

    /*
     *
     *  Прочее
     *
     */
    public static function idOfCode($code)
    {
        return self::ofCode($code)->firstOrFail()->id;
    }
}
