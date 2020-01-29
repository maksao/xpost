<?php

namespace App;

use App\Traits\FlagsTrait;
use App\Traits\LogsTrait;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'pricelist_id',
        'article',
        'article_fixed',
        'brand_name',
        'brand_id',
        'product_id',
        'name',
        'price',
        'weight',
        'core',
        'comment',
        'is_active'
    ];

    use FlagsTrait, LogsTrait;

    /*
     *
     *  Связи
     *
     */

    public function pricelist()
    {
        return $this->belongsTo(Pricelist::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /* Связи (х) */

    /*
     *
     *  Скоупы
     *
     */
    public function scopeOfArticle($q, $article)
    {
        $q->where(function($q) use ($article){
            $q->where('article_fixed', 'like', '%' . $article . '%')
                ->orWhere('article', 'like', '%' . $article . '%');
        });
    }

    public function scopeOfBrandOk($q)
    {
        $q->whereNotNull('brand_id');
    }

    public function scopeOfProductOk($q)
    {
        $q->whereNotNull('product_id');
    }

    public function scopeOfActive($q, $value = 1)
    {
        $q->where('is_active', $value);
    }
    /* Скоупы (х) */


    /*
     *
     *  Прочее
     *
     */

     // Поиск цены по артикулу и производителю
    public static function findPrices($article, $brand)
    {
        $prices = self::select(['id', 'pricelist_id','article', 'price', 'core'])
            ->where('article', (string)$article)
            ->when(is_numeric($brand), function($q) use($brand){
                return $q->where('brand_id', $brand);
            }, function($q) use($brand){
                return $q->where('brand_name', $brand);
            })
            ->with('pricelist')->get();
        return $prices;
    }

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

}
