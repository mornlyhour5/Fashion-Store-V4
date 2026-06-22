<?php

namespace App\Repository\Product;

use App\Domain\Entities\ProductEntity;
use App\Enums\GenderProduct;
use App\Enums\ProductStatus;
use App\Models\Products;
use Illuminate\Support\Str;

class ProductRepo
{
    public function getAll()
    {
        return Products::all();
    }


    public function find($product_id)
    {
        return Products::findOrFail($product_id);
    }

    public function findId($id): Products
    {
        return Products::findOrFail($id);
    }

    public function create(ProductEntity $entity): Products
    {
        return Products::create([
            'category_id' => $entity->category_id(),
            'name'        => $entity->name(),
            'slug'        => Str::slug($entity->name()),
            'description' => $entity->description() ?? null,
            'brand'       => $entity->brand(),
            'base_price'  => $entity->base_price(),
            'gender'      => $entity->gender() ?? GenderProduct::UNISEX->value,
            'status'      => $entity->status() ?? ProductStatus::ACTIVE->value,
            'image'       => $entity->image(),
            'views_count' => 0
        ]);
    }

    public function update(Products $product, array $data): Products
    {
        $product->update($data);
        return $product->fresh();
    }

    public function delete(Products $product): bool
    {
        return $product->delete();
    }
}
