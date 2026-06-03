<?php

namespace App\Repository\Product;

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


    public function create(array $data)
    {
        return Product_Images::create($data);
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
