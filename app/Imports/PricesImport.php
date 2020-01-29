<?php

namespace App\Imports;

use App\Brand;
use App\Helpers;
use App\Price;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PricesImport implements ToModel, WithChunkReading
{
    public $pricelist_id;

    public function __construct($pricelist_id)
    {
        $this->pricelist_id = $pricelist_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data = [
            'pricelist_id'  => $this->pricelist_id,
            'article'       => $row[0],
            'article_fixed' => Product::fixArticle($row[0]),
            'brand_name'    => $row[1],
            'name'          => Product::fixName($row[2]),
            'price'         => Helpers::normalizeFloat($row[3]),
            'weight'        => Helpers::normalizeFloat($row[4] ?? 0),
            'core'          => Helpers::normalizeFloat($row[5] ?? 0),
            'comment'       => $row[6] ?? ''
        ];

        // Если отсутствует артикул, бренд или цена, то игнорируем эту строку
        if( $data['article'] == '' || $data['brand_name'] == '' || $data['price'] == 0 ){
            return null;
        }

        $price = Price::where([
            'pricelist_id' => $data['pricelist_id'],
            'article_fixed' => $data['article_fixed'],
            'brand_name' => $data['brand_name']
        ])->first();

        // Ищем бренд по базе
        $data['brand_id'] = Brand::getIdByName($data['brand_name']);

        if($price) {
            $price->update([
                'price' => $data['price'],
                'core' => $data['core'],
                'weight' => $data['weight'],
                'comment' => $data['comment'],
            ]);
        } else {
            $price = Price::create($data);
        }

        return $price;
    }

    public function chunkSize() : int
    {
        return 1000;
    }
}
