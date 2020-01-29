<?php

namespace App\Imports;

use App\Brand;
use App\Helpers;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // сначала проверяем обязательные поля
        if( ! trim($row['article'] )
            || ! trim($row['brand'])
            || ! trim($row['name_rus'])
            || ! trim($row['name_eng'])
        ){
            return null;
        }

        // Ищем бренд
        if( ! $brand_id = Brand::getIdByName($row['brand'])){
            return null;
        }

        // Ищем товар и если найден, то тоже ненужен
        if( Product::getIdByArticleAndBrand($row['article'], $brand_id) ){
            return null;
        }

        $data = [
            'article'       => $row['article'],
            'article_fixed' => Product::fixArticle($row['article']),
            'brand_id'      => $brand_id,
            'name_rus'      => Product::fixName($row['name_rus']),
            'name_eng'      => Product::fixName($row['name_eng']),

            'weight'        => Helpers::normalizeFloat($row['weight'] ?? 0),
            'comment'       => $row['comment'] ?? '',
            'url'           => $row['url'] ?? ''
        ];

        return new Product($data);
    }

    public function chunkSize() : int
    {
        return 1000;
    }
}
