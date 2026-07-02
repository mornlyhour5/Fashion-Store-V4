<?php

namespace App\Domain\Entities;

use App\DTO\ProductDTO;
use App\Enums\GenderProduct;
use App\Enums\ProductStatus;
use App\Models\Products;

class ProductEntity
{

    private function __construct(
        public readonly ?int $id,
        private int     $category_id,
        private string  $name,
        //private string  $slug,
        private float   $base_price,
        private string $image,
        private ?string $description  = null,
        private ?string $brand        = null,
        private int     $gender       = GenderProduct::UNISEX->value,
        private int     $status       = ProductStatus::ACTIVE->value,
        private ?int    $views_count  = null,
    ) {}

    public static function fromDTO(ProductDTO $dto): self
    {
        return new self(
            id:     null,
            category_id:    $dto->category_id,
            name:           $dto->name,
            //slug:           $dto->slug,
            base_price:     $dto->base_price,
            description:    $dto->description,
            brand:          $dto->brand,
            gender:         $dto->gender,
            image:          $dto->image,
            status:         $dto->status,
            views_count:    $dto->views_count,
        );
    }

    public static function fromModel(Products $model): self
    {
        return new self(
            id:     null,
            category_id:    $model->category_id,
            name:           $model->name,
            //slug:           $model->slug,
            base_price:     (float) $model->base_price,
            description:    $model->description,
            brand:          $model->brand,
            gender:         $model->gender,
            image:          $model->image,
            status:         $model->status,
            views_count:    $model->views_count,
        );
    }

    public function changePrice(float $base_price): void
    {
        if ($base_price <= 0) {
            throw new \DomainException('Product price must be greater than zero.');
        }
        $this->base_price = $base_price;
    }

    // public function decreaseStock(int $quantity): void
    // {
    //     if ($quantity > $this->stock) {
    //         throw new \DomainException("Insufficient stock. Available: {$this->stock}, requested: {$quantity}.");
    //     }
    //     $this->stock -= $quantity;
    // }

    // public function increaseStock(int $quantity): void
    // {
    //     if ($quantity > $this->stock) {
    //         throw new \DomainException("Insufficient stock. Available: {$this->stock}, requested: {$quantity}.");
    //     }
    //     $this->stock += $quantity;
    // }

    public function deactivate(): void{
        $this->status = false;
    }

    public function activate(): void{
        $this->status = true;
    }

    public function id():           int     { return $this->id; }
    public function name():         string  { return $this->name; }
    public function category_id():  int     { return $this->category_id; }
    //public function slug():         string { return $this->slug; }
    public function base_price():   float   { return $this->base_price; }
    public function description():  ?string { return $this->description; }
    public function brand():        string  { return $this->brand; }
    public function gender():       int     { return $this->gender; }
    public function image():        string  { return $this->image; }
    public function status():       int     { return $this->status; }
    public function views_count():  int     { return $this->views_count; }
}
