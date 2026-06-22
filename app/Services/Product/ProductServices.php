<?php

namespace App\Services\Product;

// use App\DTO\ProductDTO;

use App\Domain\Entities\ProductEntity;
use App\DTO\ProductDTO;
// use App\Enums\GenderProduct;
// use Illuminate\Support\Str;

use App\Repository\Product\ProductRepo;
// use App\Enums\ProductStatus;
// use DomainException;
use App\Enums\GenderProduct;
use App\Enums\ProductStatus;
use Illuminate\Support\Str;

// use Illuminate\Support\Facades\DB;

class ProductServices
{
    public function __construct(protected ProductRepo $productRepo) {}

    public function getAll()
    {
        return $this->productRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->productRepo->findId($id);
    }

    public function create(ProductDTO $dto)
    {
        // return $this->productRepo->create([
        //     'category_id'  => $data['category_id'],
        //     'name'         => $data['name'],
        //     'slug'         => Str::slug($data['name']),
        //     'description'  => $data['description'] ?? null,
        //     'brand'        => $data['brand'] ?? null,
        //     'base_price'   => $data['base_price'] ?? 0,
        //     'gender'       => GenderProduct::from((int) $data['gender'] ?? GenderProduct::UNISEX->value),
        //     'status'       => ProductStatus::from((int) $data['status'] ?? ProductStatus::ACTIVE->value),
        //     'image'        => $data['image'] ?? null,
        //     'views_count'  => 0,
        // ]);

        // $existing = $this->productRepo->findBySku($dto->sku);
        // if ($existing) {
        //     throw new DomainException("A product with SKU '{$dto->sku}' already exists.");
        // }

        $product = ProductEntity::fromDTO($dto);

        return $this->productRepo->create($product);


    }

    // public function create(ProductDTO $dto): ProductDTO
    // {
    //     return $this->productRepo->create($dto);
    // }

    public function update(array $data, $id)
    {
        $product = $this->productRepo->findId($id);

        $data = [
            'category_id'  => $data['category_id'],
            'name'         => $data['name'],
            'slug'         => Str::slug($data['name']),
            'base_price'   => $data['base_price'],
            'description'  => $data['description'] ?? null,
            'brand'        => $data['brand'] ?? null,
            'gender'       => $data['gender'] ?? GenderProduct::UNISEX->value,
            'image'        => $data['image'] ?? null,
            'status'       => $data['status'] ?? ProductStatus::ACTIVE->value,
        ];

        return $this->productRepo->update($product, $data);
    }

    public function delete($id)
    {
        $product = $this->productRepo->findId($id);

        return $this->productRepo->delete($product);
    }
}
// return $this->productRepo->update($product, [
        //     'category_id'  => $data['category_id'],
        //     'name'         => $data['name'],
        //     'slug'         => Str::slug($data['name']),
        //     'description'  => $data['description'] ?? null,
        //     'brand'        => $data['brand'] ?? null,
        //     'base_price'   => $data['base_price'] ?? 0,
        //     'gender'       => $data['gender'] ?? null,
        //     'status'       => ProductStatus::from((int) $data['status']),
        //     'image'        => $data['image'] ?? null,
        //     'views_count'  => $data['views_count'] ?? 0
        // ]);
