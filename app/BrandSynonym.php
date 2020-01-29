<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandSynonym extends Model
{
    public $timestamps = false;

    protected $fillable = ['brand_id','name'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
