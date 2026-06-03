<?php

namespace App\Services\Product;

use App\Repository\Product\CategoryRepo;
use Illuminate\Support\Str;

class CategoryServices
{
    public function __construct(protected CategoryRepo $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getData()
    {
        return $this->categoryRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->categoryRepo->getWhereId($id);
    }

    public function create(array $data)
    {
        $data = [
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'parent_id' => $data['parent_id'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'sort_order' => $data[''] ?? 1,
            'image' => $data[''] ?? null
        ];

        return $this->categoryRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $category = $this->categoryRepo->findId($id);

        $data = [
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'parent_id' => $data['parent_id'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'sort_order' => $data[''] ?? 1,
            'image' => $data[''] ?? null
        ];

        return $this->categoryRepo->update($category, $data);
    }

    public function delete($id)
    {
        $cate = $this->categoryRepo->findId($id);

        return $this->categoryRepo->delete($cate);
    }
}
