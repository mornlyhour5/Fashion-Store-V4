<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id'          => $this->product_id,
            'sku'                 => $this->sku,
            'color'               => $this->color,
            'size'                => $this->size,
            'price'               => $this->price,
            'stock'               => $this->stock,
            'low_stock_threshold' => $this->low_stock_threshold,
            'image'               => $this->image
        ];
    }
}
