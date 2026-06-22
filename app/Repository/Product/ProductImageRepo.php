<?php

namespace App\Repository\Product;

use App\Domain\Entities\ProductImageEntities;
use App\Models\Product_Images;

class ProductImageRepo
{
    public function getAll()
    {
        return Product_Images::all();
    }

    public function findId($id)
    {
        return Product_Images::findOrFail($id);
    }


    public function create(ProductImageEntities $Entities): Product_Images
    {
        return Product_Images::create([
            'product_id' => $Entities->id(),
            'image_url' => $Entities->imageUrl(),
            'is_main' => $Entities->isMain(),
            'sort_order' => $Entities->sortOrder(),
            'product_variant_id' => $Entities->productVariantId()
        ]);
    }

    public function update(Product_Images $image, array $data)
    {
        $image->update($data);

        return $image->fresh();
    }

    public function delete(Product_Images $image)
    {
        return $image->delete();
    }
}
