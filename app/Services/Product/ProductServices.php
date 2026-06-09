<?php

namespace App\Services\Product;
use Illuminate\Support\Str;

use App\Repository\Product\ProductRepo;
use App\Enums\ProductStatus;

class ProductServices
{
    public function __construct(protected ProductRepo $productRepo) {}

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
        return $this->productRepo->create([
            'category_id'  => $data['category_id'],
            'name'         => $data['name'],
            'slug'         => Str::slug($data['name']),
            'description'  => $data['description'] ?? null,
            'brand'        => $data['brand'] ?? null,
            'base_price'   => $data['base_price'] ?? 0,
            'gender'       => $data['gender'] ?? null,
            'status'       => ProductStatus::from((int) $data['status'] ?? ProductStatus::ACTIVE->value),
            'image'        => $data['image'] ?? null,
            'views_count'  => 0, // never trust user input for this
        ]);
    }

    public function update(array $data, $id)
    {
        $product = $this->productRepo->findId($id);
        return $this->productRepo->update($product, [
            'category_id'  => $data['category_id'],
            'name'         => $data['name'],
            'slug'         => Str::slug($data['name']),
            'description'  => $data['description'] ?? null,
            'brand'        => $data['brand'] ?? null,
            'base_price'   => $data['base_price'] ?? 0,
            'gender'       => $data['gender'] ?? null,
            'status'       => ProductStatus::from((int) $data['status']),
            'image'        => $data['image'] ?? null,
            'views_count'  => $data['views_count'] ?? 0
        ]);
    }

    public function delete($id)
    {
        $product = $this->productRepo->findId($id);

        return $this->productRepo->delete($product);
    }
}
