<?php

namespace App\Services\Product;

use App\Repository\Product\CategoryRepo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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

    public function create(array $data, ?UploadedFile $image = null)
    {
        $imagePath = null;

        if ($image) {
            // Stores to storage/app/public/categories, returns e.g. "categories/abc123.webp"
            $imagePath = $image->store('categories', 'public');
        }

        $payload = [
            'name'       => $data['name'],
            'slug'       => Str::slug($data['name']),
            'parent_id'  => $data['parent_id'] ?? null,
            'status'     => $data['status'] ?? 1,
            'sort_order' => $data['sort_order'] ?? 1,
            'image'      => $imagePath, // store relative path, not full URL
        ];

        return $this->categoryRepo->create($payload);
    }

    public function update(int $id, array $data, ?UploadedFile $image = null)
    {
        $category = $this->categoryRepo->findId($id);

        if (!$category) {
            abort(404, 'Category not found');
        }

        $imagePath = $category->image; // keep existing image by default

        if ($image) {
            // delete old file first so storage doesn't accumulate orphaned images
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $image->store('categories', 'public');
        }

        $payload = [
            'name'       => $data['name'],
            'slug'       => $data['slug'] ?? Str::slug($data['name']),
            'parent_id'  => $data['parent_id'] ?? null,
            'status'     => $data['status'] ?? $category->status,
            'sort_order' => $data['sort_order'] ?? $category->sort_order,
            'image'      => $imagePath,
        ];

        return $this->categoryRepo->update($id, $payload);
    }

    public function delete($id)
    {
        $cate = $this->categoryRepo->findId($id);

        return $this->categoryRepo->delete($cate);
    }
}
