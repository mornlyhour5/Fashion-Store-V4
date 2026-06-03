<?php

namespace App\Services\Product;

use App\Repository\Product\ProductImageRepo;

class ProductImageServices
{
    public function __construct(protected ProductImageRepo $productImageRepo)
    {
        $this->productImageRepo = $productImageRepo;
    }

    public function getAll()
    {
        return $this->productImageRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->productImageRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'product_id' => $data['product_id'],
            'image_url' => $data['image_url'],
            'is_main' => $data['is_main'] ?? false,
            'sort_order' => $data['sort_order'] ?? 0
        ];

        return $this->productImageRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $image = $this->productImageRepo->findId($id);

        $data = [
            'product_id' => $data['product_id'],
            'image_url' => $data['image_url'],
            'is_main' => $data['is_main'] ?? false,
            'sort_order' => $data['sort_order'] ?? 0
        ];

        return $this->productImageRepo->update($image, $data);
    }

    public function delete($id)
    {
        $image = $this->productImageRepo->findId($id);

        return $this->productImageRepo->delete($image);

    }
}
