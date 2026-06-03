<?php

namespace App\Services\Product;
use Illuminate\Support\Str;

use App\Repository\Product\ProductRepo;

class ProductServices
{
    public function __construct(protected ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAll()
    {
        return $this->productRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->productRepo->getWhereId($id);
    }


    public function create(array $data)
    {
        $data = [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'],
            'brand' => $data['brand'],
            'base_price' => $data['base_price'] ?? 0,
            'gender' => $data['gender'],
            'status' => $data['status'],
            'image' => $data['image'],
            'views_count' => $data['views_count'] ?? 0
        ];

        return $this->productRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $product = $this->productRepo->findId($id);
        $data = [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'],
            'brand' => $data['brand'],
            'base_price' => $data['base_price'] ?? 0,
            'gender' => $data['gender'],
            'status' => $data['status'],
            'image' => $data['image'],
            'views_count' => $data['views_count'] ?? 0
        ];
        return $this->productRepo->update($product, $data);
    }

    public function delete($id)
    {
        $product = $this->productRepo->findId($id);

        return $this->productRepo->delete($product);
    }
}
