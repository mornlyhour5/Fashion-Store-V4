<?php

namespace App\Repository\Product;

use App\Models\Product_Variants;

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

    public function create(array $data)
    {
        return Product_Variants::create($data);
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

    public function decreaseStock($id, $quantity)
    {
        $variant = $this->findId($id);

        if ($variant->stock < $quantity) {
            throw new \Exception("Product variant ID {$id} is out of stock.");
        }

        $variant->stock -= $quantity;
        $variant->save();

        return $variant;
    }
}
