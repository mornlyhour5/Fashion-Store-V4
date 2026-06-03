<?php

namespace App\Services\Product;

use App\Repository\Product\ProductVariantRepo;

class ProductVariantServices
{
    public function __construct(protected ProductVariantRepo $productVariantRepo)
    {
        $this->productVariantRepo = $productVariantRepo;
    }

    public function getAll()
    {
        return $this->productVariantRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->productVariantRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'product_id' => $data['product_id'],
            'sku'        => $data['sku'],
            'color'      => $data['color'],
            'size'       => $data['size'],
            'price'      => $data['price'],
            'stock'      => $data['stock'] ?? 0,
            'low_stock_threshold' => $data['low_stock_threshold'] ?? 5,
            'image'      => $data['image']
        ];

        return $this->productVariantRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $productVariant = $this->productVariantRepo->findId($id);
        $data = [
            'product_id' => $data['product_id'],
            'sku'        => $data['sku'],
            'color'      => $data['color'],
            'size'       => $data['size'],
            'price'      => $data['price'],
            'stock'      => $data['stock'] ?? 0,
            'low_stock_threshold' => $data['low_stock_threshold'] ?? 5,
            'image'      => $data['image']
        ];

        return $this->productVariantRepo->update($productVariant, $data);
    }

    public function delete($id)
    {
        $productVariant = $this->productVariantRepo->findId($id);

        return $this->productVariantRepo->delete($productVariant);
    }
}
