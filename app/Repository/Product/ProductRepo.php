<?php

namespace App\Repository\Product;

use App\Models\Products;

class ProductRepo
{
    public function getAll()
    {
        return Products::all();
    }

    public function getWhereId($id)
    {
        return Products::findOrFail($id);
    }

    public function find($product_id)
    {
        return Products::findOrFail($product_id);
    }

    public function findId($id)
    {
        return Products::findOrFail($id);
    }

    public function create(array $data){
        return Products::create($data);
    }

    public function update(Products $products, array $data)
    {
        $products->update($data);
        return $products->fresh();
    }

    public function delete(Products $products)
    {
        return $products->delete();
    }
}
