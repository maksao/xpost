<?php

namespace App\Imports;

use App\Brand;
use App\OrderPosition;
use App\Price;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class OrderPositionsImport implements ToModel, WithHeadingRow
{
    public $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data = [
            'order_id' => $this->order_id,
            'article' => $row['artikul'],
            'article_fixed' => Product::fixArticle($row['artikul']),
            'brand_name' => $row['proizvoditel'],
            'name_rus' => $row['naimenovanie_rus'],
            'name_eng' => $row['naimenovanie_angl'],
            'quantity' => $row['kol'],
            'inner_number' => $row['nomer_zakaza'],

            'comment' => ''
        ];

        // если указан бренд, то пробиваем его по базе
        if( $data['brand_name']){

            // если бренд найден, то пробиваем по базе товар
            if($brand = Brand::getByName($data['brand_name'])){

                $data['brand_id'] = $brand->id;
                $data['markup'] = $brand->markup;

                if ( $data['article'] ){
                    $product = Product::getByArticleAndBrand($data['article'], $brand->id);

                    // Если товар найден, то подставлям названия и ищем цену
                    if($product){
                        $data['product_id'] = $product->id;
                        $data['name_rus'] = $product->name_rus;
                        $data['name_eng'] = $product->name_eng;

                        $prices = Price::findPrices($data['article'], $data['brand_id']);

                        if($prices->count()){
                            foreach ($prices as $key => $price) {
                                if($key == 0){
                                    $data['price'] = $price->price;
                                    $data['core'] = $price->core;
                                } else {
                                    $data['comment'] .= 'Цены:'. $price->pricelist->name . ':' . $price->price . '|Core:' . $price->core . '; ';
                                }
                            }
                        }
                    }
                }
            }

        }

        $position = OrderPosition::create($data);
        $position->updatePrices();

        return $position;
    }


}
