<?php

namespace App\Domain\Entities;
use App\DTO\ProductVariantDTO;
use App\Models\Product_Variants;

class ProductVariantEntities
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly ?int $id,
        public readonly int $product_id,
        public readonly string $sku,
        public readonly string $color,
        public readonly string $size,
        public readonly float $price,
        public readonly int $stock,
        public readonly int $low_stock_threshold,
        public readonly ?string $image = null,
    ) {}

    public static function fromDTO(ProductVariantDTO $dto): self
    {
        return new self(
            id: null,
            product_id: $dto->product_id,
            sku:        $dto->sku,
            color:      $dto->color,
            size:       $dto->size,
            price:      $dto->price,
            stock:      $dto->stock,
            low_stock_threshold: $dto->low_stock_threshold,
            image:      $dto->image
        );
    }

    public static function fromModel(Product_Variants $model): self
    {
        return new self(
            id:             null,
            product_id:     $model->product_id,
            sku:            $model->sku,
            color:          $model->color,
            size:           $model->size,
            price:          (float) $model->price,
            stock:          $model->stock,
            low_stock_threshold: $model->low_stock_threshold,
            image:          $model->image
        );
    }

    public function decreaseStock(int $quantity): void
    {
        if ($quantity > $this->stock) {
            throw new \DomainException("Insufficient stock. Available: {$this->stock}, requested: {$quantity}.");
        }
    }

    public function increaseStock(int $quantity): void
    {
        if($quantity > $this->stock){
            throw new \DomainException("Insufficient stock. Available: {$this->stock}, requested: {$quantity}.");
        }
        $this->stock += $quantity;
    }

    public function id():           int     { return $this->id; }
    public function product_id():   int     { return $this->product_id; }
    public function sku():          string  { return $this->sku; }
    public function color():        string  { return $this->color; }
    public function size():         string  { return $this->size; }
    public function price():        float   { return $this->price; }
    public function stock():        int     { return $this->stock; }
    public function low_stock_threshold():  int { return $this->low_stock_threshold; }
    public function image():        string  { return $this->image; }
}
