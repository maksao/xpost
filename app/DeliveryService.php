<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryService extends Model
{
    const OBJECT_CODE = 'delivery_services';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'url',
        'description',
    ];
}
