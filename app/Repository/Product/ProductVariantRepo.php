<?php

namespace App\Repository\Product;

use App\Models\Product_Variants;
use App\Domain\Entities\ProductVariantEntities;

class ProductVariantRepo
{
    public function getAll()
    {
        return Product_Variants::all();
    }

    public function findId($id)
    {
        return Product_Variants::findOrFail($id);
    }
    public function find($id)
    {
        return Product_Variants::find($id);
    }

    public function create(ProductVariantEntities $entity): Product_Variants
    {
        // return Product_Variants::create($data);
        return Product_Variants::create([
            'product_id' => $entity->product_id(),
            'sku'        => $entity->sku(),
            'color'      => $entity->color(),
            'size'       => $entity->size(),
            'price'      => $entity->price(),
            'stock'      => $entity->stock() ?? 0,
            'low_stock_threshold' => $entity->low_stock_threshold() ?? 5,
            'image'      => $entity->image()
        ]);
    }

    public function update(Product_Variants $productVariants, array $data)
    {
        $productVariants->update($data);

        return $productVariants->fresh();
    }

    public function delete(Product_Variants $productVariants)
    {
        return $productVariants->delete();
    }

    // public function decreaseStock($id, $quantity)
    // {
    //     $variant = $this->findId($id);

    //     if ($variant->stock < $quantity) {
    //         throw new \Exception("Product variant ID {$id} is out of stock.");
    //     }

    //     $variant->stock -= $quantity;
    //     $variant->save();

    //     return $variant;
    // }
}
