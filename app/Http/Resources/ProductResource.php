<?php

namespace App\Http\Resources;

use App\Enums\GenderProduct;
use App\Enums\ProductStatus;
use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Helpers\HelperMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $firstVariantImage = $this->relationLoaded('variants')
            ? $this->variants
                ->flatMap(fn($v) => $v->relationLoaded('images') ? $v->images : collect())
                ->sortByDesc('is_main')
                ->first()
            : null;

        $imageFile = $firstVariantImage->image ?? $this->thumbnail ?? null;

        return [
            'id'          => $this->id,
            'category_id' => $this->category_id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description ?? null,
            'brand'       => $this->whenLoaded('brand'),
            'base_price'  => $this->base_price,
            'gender'      => $this->gender ?? GenderProduct::UNISEX->value,
            'status'      => $this->status ?? ProductStatus::ACTIVE->value,
            'image'       => HelperMedia::getImageUrl(
                ImageBuket::COMPANY->value,
                ImageDirectory::PRODUCT->value,
                $imageFile
            ),
            'views_count' => $this->views_count ?? 0,
            'variants'    => ProductVariantResource::collection($this->whenLoaded('variants')),
        ];
    }
}
