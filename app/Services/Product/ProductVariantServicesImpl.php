<?php

namespace App\Services\Product;

use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Exceptions\DuplicateExcept;
use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Helpers\HelperMedia;
use App\Repository\Contracts\ProductImageRepository;
use App\Repository\Contracts\ProductVariantRepository;
use App\Services\Contracts\ProductVariantServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductVariantServicesImpl implements ProductVariantServices
{
    public function __construct(
        protected ProductVariantRepository $productvariantrepository,
        protected ProductImageRepository $productImageRepository,
        protected CustomValidator $validator,
    ){}

    private function variantValidator(array $data)
    {
        $rules = [
            'product_id'            => 'required|exists:products,id',
            'sku'                   => 'required|string|max:150',
            'color'                 => 'required|string|max:50',
            'size'                  => 'required|string|max:20',
            'unit_price'            => 'required|numeric|min:0',
            'quantity'              => 'required|numeric|min:0',
            'low_stock_threshold'   => 'required|integer|min:0',
            'barcode'               => 'nullable|string|max:255',
            'cost_price'            => 'nullable|numeric|min:0',
            'status'                => 'nullable|integer',
            'weight'                => 'nullable|numeric|min:0',

            'images'                => 'nullable|array',
            'images.*'              => 'nullable|image|max:5120',
        ];
        return $this->validator->validate($data, $rules);
    }

    public function getAllVariant()
    {
        return $this->productvariantrepository->getAll();
    }

    public function getVariantById(Request $request, int $id): mixed
    {
        $variant = $this->productvariantrepository->findById($id);

        if (!$variant) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product_variant')
            ]));
        }

        return $variant;
    }

    public function create(Request $request): Model
    {
        $validated = $this->variantValidator($request->all());

        if ($this->productvariantrepository->checkDuplicateColumn(['sku' => $validated['sku']])) {
            throw new DuplicateExcept(__('messages.duplicated_sku', [
                'info' => __('general.product_variant')
            ]));
        }

        return DB::transaction(function () use ($validated, $request) {
            $variantData = collect($validated)->except('images')->toArray();
            $variant = $this->productvariantrepository->create($variantData);

            $this->storeImages($request, $variant->id);

            return $this->productvariantrepository->findById($variant->id);
        });
    }

    public function update(Request $request, int $id): mixed
    {
        $variant = $this->productvariantrepository->findById($id);

        if (!$variant) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product_variant')
            ]));
        }

        $validated = $this->variantValidator($request->all());

        if ($this->productvariantrepository->checkDuplicateColumn(['sku' => $validated['sku']], $id, true)) {
            throw new DuplicateExcept(__('messages.duplicated_sku', [
                'info' => __('general.product_variant')
            ]));
        }

        return DB::transaction(function () use ($validated, $request, $id) {
            $variantData = collect($validated)->except('images')->toArray();
            $this->productvariantrepository->updateById($id, $variantData);

            $this->storeImages($request, $id);

            return $this->productvariantrepository->findById($id);
        });
    }

    public function delete(int $id): void
    {
        $variant = $this->productvariantrepository->findById($id);

        if (!$variant) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product_variant')
            ]));
        }

        foreach ($this->productImageRepository->getByVariant($id) as $image) {
            HelperMedia::deleteUploadedFile(
                $image->image,
                ImageBuket::COMPANY->value,
                ImageDirectory::VARIANT->value
            );
        }

        $this->productvariantrepository->deleteById($id);
    }

    private function storeImages(Request $request, int $variantId): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        $files = $request->file('images');
        $existingCount = $this->productImageRepository->countByVariant($variantId);

        foreach ($files as $index => $file) {
            $storedName = HelperMedia::saveImageFileOrBase64(
                $file,
                \App\Enums\ImageBuket::COMPANY->value,
                \App\Enums\ImageDirectory::VARIANT->value
            );

            $this->productImageRepository->create([
                'product_variant_id' => $variantId,
                'image'              => $storedName,
                'is_main'            => $existingCount === 0 && $index === 0,
                'sort_order'         => $existingCount + $index,
            ]);
        }
    }

    public function deleteImage(int $variantId, int $imageId): void
    {
        $image = $this->productImageRepository->findById($imageId);

        if (!$image || $image->product_variant_id !== $variantId) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product_image')
            ]));
        }

        HelperMedia::deleteUploadedFile(
            $image->image,
            ImageBuket::COMPANY->value,
            ImageDirectory::VARIANT->value
        );
        $this->productImageRepository->deleteById($imageId);

        if ($image->is_main) {
            $next = $this->productImageRepository->getByVariant($variantId)->first();
            if ($next) {
                $this->productImageRepository->updateById($next->id, ['is_main' => true]);
            }
        }
    }

    public function setMainImage(int $variantId, int $imageId): void
    {
        $image = $this->productImageRepository->findById($imageId);

        if (!$image || $image->product_variant_id !== $variantId) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product_image')
            ]));
        }

        $this->productImageRepository->clearMainForVariant($variantId);
        $this->productImageRepository->updateById($imageId, ['is_main' => true]);
    }
}
