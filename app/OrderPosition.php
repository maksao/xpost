<?php

namespace App;

use App\Traits\LogsTrait;
use Illuminate\Database\Eloquent\Model;

class OrderPosition extends Model
{
    use LogsTrait;

    protected $fillable = [
        'order_id',
        'article',
        'article_fixed',
        'brand_name',
        'name_rus',
        'name_eng',
        'brand_id',
        'product_id',
        'quantity',
        'price',
        'core',
        'markup',
        'price_contractor',
        'price_sum',
        'inner_number',
        'url',
        'comment',
        'status_id',
    ];

    /*
     *
     *  Связи
     *
     */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {

    }

    public function status()
    {
        return $this->belongsTo(OrderPositionStatus::class);
    }

    /* Связи (х) */

    /*
     *
     *  Скоупы
     *
     */

    public function scopeOfStatus($q, $status)
    {

        if( is_array($status) ) {

        } elseif( is_string($status) ){
            $q->where('status_id', OrderPositionStatus::idOfCode($status));
        } else {
            $q->where('status_id', $status);
        }
    }


    /* Скоупы (х) */

    /*
     *
     *  Прочее
     *
     */

    // отвечает найден ли бренд в справочнике
    public function isBrandOk()
    {
        return !! $this->brand_id;
    }

    // отвечает найден ли товар в справочнике
    public function isProductOk()
    {
        return !! $this->product_id;
    }

    // Расчет цены контрагента и итоговой цены
    public function updatePrices()
    {
        $this->price_contractor = $this->price * (1 + $this->markup / 100) + $this->core;
        $this->price_sum = $this->price_contractor * $this->quantity;
        $this->save();
        $this->refresh();

        $this->order->updatePrices();
    }


}
