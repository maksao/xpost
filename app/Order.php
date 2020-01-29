<?php

namespace App;

use App\Traits\LogsTrait;
use DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use LogsTrait;

    protected $fillable = [
        'user_id',
        'number',
        'delivery_type_id',
        'delivery_cost',
        'status_id',
        'invoice_id',
        'comment',
        'price_SZP',
        'price_SZP_D',
        'price',
        'price_D'
    ];


    /*
     *
     *  Связи
     *
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delivery_type()
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function positions()
    {
        return $this->hasMany(OrderPosition::class);
    }

    public function tracks()
    {
        return $this->hasMany(OrderTrack::class);
    }

    /* Связи (х) */

    /*
     *
     *  Скоупы
     *
     */

    // Только подтвержденные заказы
    public function scopeOfConfirmed($q)
    {
        $q->where('status_id', '>', 1);
    }

    /* Скоупы (х) */

    /*
     *
     *  Прочее
     *
     */

    /**
     * Возвращает цветовую тему для текущего статуса
     *
     * @return mixed
     */

    public function getThemeAttribute()
    {
        return $this->status->theme;
    }

    /**
     * Обновляет статус в зависимости от статусов позиций
     */
    public function updateStatus()
    {
        // получаем сначала просто количество позиций
        $total = $this->positions()->count();

        // если позиций нет, или если статус всех позициий = 1, то заказ не заказан (подтвержден) и статус будет 1
        if( ! $total || $this->positions()->where('status_id',1)->count() == $total){
            $this->status_id = 1;
        }
        // если статус всех позициий = 2, то заказ новый
        elseif ($this->positions()->where('status_id',2)->count() == $total){
            $this->status_id = 2;
        }
        // если в заказе есть позиции со статусом между 3 и 8 включительно, то заказ в обработке
        elseif ($this->positions()->whereBetween('status_id',[3,8])->count()){
            $this->status_id = 3;
        }
        // если статусы всех позиций 9 и выше, то заказ закрыт
        elseif($this->positions()->where('status_id', '>=',9)->count() == $total){
            $this->status_id = 4;
        }
        // если ничего не прошло то делаем заказ
        else {
            $this->status_id = 1;
        }

        $this->save();

        return true;
    }

//    public function getCost()
//    {
//        return $this->positions()->sum('price_sum');
//    }

    // Пересчитывает и обновляет все цены
    public function updatePrices()
    {
        $this->load('positions');

        // Стоимость заказа поставщика
        $this->price_SZP = $this->positions->sum(function ($position){
            return ($position->price + $position->core) * $position->quantity;
        });

        // Стоимость заказа поставщика с доставкой
        $this->price_SZP_D = $this->price_SZP + $this->delivery_cost;

        // Стоимость заказа
        $this->price = $this->positions->sum('price_sum');

        // Стоимость заказа с доставкой
        $this->price_D = $this->price + $this->delivery_cost;

        $this->save();
    }

    // СЗП - Стоимость заказа поставщика
//    public function getSZP()
//    {
//        return $this->positions()->get()->sum(function ($position){
//            return ($position->price + $position->core) * $position->quantity;
//        });
//    }

    // Проверка является ли татус заказа переданным.
    // Принимает значения число - id статуса, строка - код статуса
    public function isStatus($status)
    {
        if(is_numeric($status)){
            return $this->status_id === $status;
        }

        return $this->status->code === $status;
    }
}
