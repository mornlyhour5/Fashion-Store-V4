<?php

namespace App\Repository\Product;

use App\Models\Categories;

class CategoryRepo
{
    public function getAll()
    {
        return Categories::all();
    }

    public function getWhereId($id)
    {
        return Categories::findOrFail($id);
    }

    public function findId($id)
    {
        return Categories::findOrFail($id);
    }

    public function create(array $data)
    {
        return Categories::create($data);
    }

    public function update(int $id, array $data)
    {
        $category = Categories::findOrFail($id);
        $category->update($data);
        return $category->fresh();
    }

    public function delete(Categories $categories)
    {
        return $categories->delete();
    }
}
