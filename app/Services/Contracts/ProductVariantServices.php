<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ProductVariantServices
{
    public function getAllVariant();

    public function getVariantById(Request $request, int $id): mixed;

    public function create(Request $request): Model;

    public function update(Request $request, int $id): mixed;

    public function delete(int $id);

    public function deleteImage(int $variantId, int $imageId): void;

    public function setMainImage(int $variantId, int $imageId): void;
}
