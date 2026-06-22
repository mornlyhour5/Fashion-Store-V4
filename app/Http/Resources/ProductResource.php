<?php

namespace App\Http\Resources;

use App\Enums\GenderProduct;
use App\Enums\ProductStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category_id' => $this->category_id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description ?? null,
            'brand'       => $this->brand,
            'base_price'  => $this->base_price,
            'gender'      => $this->gender ?? GenderProduct::UNISEX->value,
            'status'      => $this->status ?? ProductStatus::ACTIVE->value,
            'image'       => $this->image,
            'views_count' => 0
        ];
    }
}
