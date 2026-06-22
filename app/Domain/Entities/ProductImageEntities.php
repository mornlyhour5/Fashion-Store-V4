<?php

namespace App\Domain\Entities;
use App\DTO\ProductImageDTO;
use App\Models\Product_Images;

class ProductImageEntities
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly int     $product_id,
        public readonly string  $image_url,
        public readonly string  $is_main,
        public readonly int     $sort_order,
        public readonly int     $product_variant_id
    ) {}

    public static function fromDTO(ProductImageDTO $dto): self
    {
        return new self(
            product_id:          $dto->product_id,
            image_url:           $dto->image_url,
            is_main:             $dto->is_main,
            sort_order:          $dto->sort_order,
            product_variant_id:  $dto->product_variant_id
        );
    }

    public static function fromModel(Product_Images $model): self
    {
        return new self(
            product_id:          $model->product_id,
            image_url:           $model->image_url,
            is_main:             $model->is_main,
            sort_order:          $model->sort_order,
            product_variant_id:  $model->product_variant_id
        );
    }

    public function id(): int       { return $this->product_id; }
    public function imageUrl(): string { return $this->image_url; }
    public function isMain(): string   { return $this->is_main; }
    public function sortOrder(): int    { return $this->sort_order; }
    public function productVariantId(): int { return $this->product_variant_id; }
}
