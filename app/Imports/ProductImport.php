<?php

namespace App\Imports;

use App\Services\Contracts\ProductServices;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function __construct(private ProductServices $productServices) {}
    public function collection(Collection $rows)
    {
        $data = [];

        foreach ($rows as $row){
            $data[] = [
                'product'        => $row['product'] ?? null,
                'slug'           => $row['slug'] ?? null,
                'description'    => $row['category'] ?? null,
                'brand_id'       => $row['brand'] ?? null,
                'gender'         => $row['gender'] ?? null,
                'base_price'     => $row['price'] ?? null,
                'status'         => $row['price'] ?? null,
                'views_count'    => $row['views'] ?? null
            ];
        }
        $this->productServices->implementData($data);
    }
}
