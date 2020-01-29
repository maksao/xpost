<?php

namespace App;

use App\Traits\LogsTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const OBJECT_CODE = 'products';

    protected $fillable = [
        'article',
        'article_fixed',
        'brand_id',
        'name_rus',
        'name_eng',
        'weight',
        'comment',
        'url',
    ];

    use LogsTrait;

    /*
     *
     *  Связи
     *
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class)->withDefault(['name'=>'нет']);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
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
    /* Скоупы (х) */


    /*
     *
     *  Прочее
     *
     */

    /**
     * Приводит артикул в соответствие с принятым нами стандартом хранения артикулов
     * все буквы заглавные, может содержать только буквы латинского алфавита и цифры
     *
     * @param $article
     * @param bool $original - если выставлен, то ничего вырезано небудет, а только все буквы переведены в верхний регистр
     * @return mixed
     */
    public static function fixArticle($article, $original=false)
    {
        $article = trim($article);

        if( $original === true ){
            $article = mb_strtoupper( $article );
        }else{
            $article = mb_strtoupper( preg_replace ("/[^a-zA-Z0-9]/","",$article) );
        }
        return $article;
    }

    /**
     * Приводит название к более менее читабельному виду
     *
     * @param $name
     * @return mixed
     */
    public static function fixName($name)
    {
        // убираем пробелы по краям
        $name = trim($name);
        // делаем все буквы строчными
        $name = mb_strtolower($name);
        // делаем первую букву заглавной
        $name = Helpers::mb_ucfirst($name);
        // убираем все лишние пробелы в тексте
        $name = preg_replace ("/\s{2,}/"," ",$name);

        return $name;
    }

    /*
     * Пытается найти запись по артикулу и производителю и вернуть
     * Если указан onlyId, то возвращает только id
     */
    public static function getByArticleAndBrand($article, $brand, $onlyId = false)
    {
        if(is_string($brand)) {
            $brand_id = Brand::getIdByName($brand);
            if (!$brand_id) {
                return null;
            }
        } else {
            $brand_id = $brand;
        }

        $query = self::where('article', (string)$article)->where('brand_id', $brand_id);
        $result = $onlyId ? $query->value('id') : $query->first();

        return $result;
    }

    public static function getIdByArticleAndBrand($article, $brand)
    {
        return self::getByArticleAndBrand($article, $brand, true);
    }

}
