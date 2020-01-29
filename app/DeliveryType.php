<?php

namespace App;

use App\Traits\PositionTrait;
use Illuminate\Database\Eloquent\Model;

class DeliveryType extends Model
{
    const OBJECT_CODE = 'delivery_types';

    public $timestamps = false;

    protected $fillable = [
        'pos',
        'name',
        'description',
    ];

    use PositionTrait;


}
