<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // Проверяем работу


    const OBJECT_CODE = 'brands';

	public $timestamps = false;

    protected $fillable = ['name', 'markup', 'confirmed'];

    use Traits\LogsTrait;


    /*
     *
     *  Связи
     *
     */

    public function synonyms()
    {
        return $this->hasMany(BrandSynonym::class);
    }

    public function discount_groups()
    {
        return $this->belongsToMany(DiscountGroup::class)->withPivot('discount');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function descriptions()
    {
        return $this->hasOne(BrandDescription::class);
    }

	public function markups()
    {
        return $this->hasOne(BrandMarkup::class);
    }

    public function c_order_positions()
    {
        return $this->hasManyThrough(
            OrderPosition::class,
            Product::class,
            'brand_id',
            'c_product_id');
    }
    /* Связи (х) */

    /*
     *
     *  Скоупы
     *
     */

    /* Скоупы (х) */

    /*
     *
     *  Прочее
     *
     */

    /**
     * Приводит название к нашему принятому стандарту
     *
     * удаляет пробелы по краям
     * все буквы делает строчными,
     * удаляет все лишние пробелы между словами
     *
     * @param $name
     * @return mixed
     */
    public static function normalizeName($name)
    {
        // убираем пробелы по краям
        $name = trim($name);
        // делаем все буквы строчными
        $name = mb_strtolower( $name );
        // убираем все лишние пробелы в тексте
        $name = preg_replace ("/\s{2,}/"," ",$name);
        // убираем все лишние символы
        // $name =  preg_replace ("/[^-a-zA-Z0-9\s]/","",$name);

        return $name;
    }

    /**
     * Приводит название к нашему принятому стандарту и
     * после сравнивает результат с синонимами названия и если есть, то возвращает
     * утвержденное название, если нет, то возвращает результат
     *
     * @param $name
     * @return mixed
     */
    public static function fixName($name)
    {
        $name = self::normalizeName($name);
        if( $synonym = BrandSynonym::where('name',$name)->with('brand')->first() ) {
            $name = $synonym->brand->name;
        }
        return $name;
    }

    /**
     * Ищет id по названию
     * @param $name
     * @return int
     */
    public static function getIdByName( $name )
    {
        $name = self::normalizeName( trim( $name ) );
        if( ! $result = BrandSynonym::select('brand_id')->where('name', $name)->first() ) {
            return null;
        }
        return $result->brand_id;
    }

    /**
     * Ищет запись по названию
     * @param $name
     * @return int
     */
    public static function getByName( $name )
    {
        $name = self::normalizeName( trim( $name ) );
        if( !$id = self::getIdByName($name) ){
            return null;
        }
        return self::find($id);
    }



}
