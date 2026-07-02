<?php

namespace App\Repository\Product;

use App\Models\Brand;

class BrandRepo
{
    public function getAll()
    {
        return Brand::all();
    }

    public function findId(int $id)
    {
        return Brand::findOrFail($id);
    }

    public function create(array $data)
    {
        return Brand::create($data);
    }

    public function update(int $id, array $data)
    {
        $brand = Brand::findOrFail($id);
        $brand->update($data);
        return $brand->fresh();
    }

    public function delete(Brand $Brand)
    {
        return $Brand->delete();
    }
}
