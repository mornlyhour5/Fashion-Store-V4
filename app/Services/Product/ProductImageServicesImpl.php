<?php

namespace App\Services\Product;

use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Exceptions\DuplicateExcept;
use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Helpers\HelperMedia;
use App\Repository\Contracts\ProductImageRepository;
use App\Services\Contracts\ProductImageServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductImageServicesImpl implements ProductImageServices
{
    public function __construct(
        protected ProductImageRepository $productimagerepository,
        protected CustomValidator $validator
    ) {}

    private function productImage(array $data)
    {
        $rules = [
            'image'          => 'nullable',
            'is_main'            => 'nullable',
            'sort_order'         => 'required|integer|min:0',
            'product_variant_id' => 'required|exists:product_variants,id'
        ];
        return $this->validator->validate($data, $rules);
    }

    public function getAllProductImage(Request $request)
    {
        return $this->productimagerepository->getAll();
    }

    public function getProductImageWhereId(Request $request, int $id): mixed
    {
        $product = $this->productimagerepository->findById($id, $request->all());

        if (!$product) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product_image')
            ]));
        }
        return $product;
    }

    public function create(Request $request): Model
    {
        $validated = $this->productImage($request->all());

        $imageFile = $request->file('image');
        if ($imageFile) {
            $result = HelperMedia::saveImageFileOrBase64(
                $imageFile,
                'image',
                ImageBuket::COMPANY->value,
                ImageDirectory::VARIANT->value
            )->filename;

            $validated['image'] = $result->filename ?? null;
        }

        return $this->productimagerepository->create($validated);
    }

    public function update(Request $request, int $id): Model
    {
        $product = $this->productimagerepository->findById($id);

        if (!$product) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product_image')
            ]));
        }

        $validated = $this->productImage($request->all());

        if ($this->productimagerepository->checkDuplicateColumn(['image' => $validated['image']], $id, true)) {
            throw new DuplicateExcept(__('messages.duplicated_name', [
                'info' => __('general.product_variant_id')
            ]));
        }

        $imageFile = $request->file('image');
        if ($imageFile) {
            if (!empty($product->image)) {
                HelperMedia::deleteUploadedFile(
                    'image',
                    ImageBuket::COMPANY->value,
                    ImageDirectory::VARIANT->value,
                    $product->image
                );
            }

            $result = HelperMedia::saveUploadedFile(
                $imageFile,
                'image',
                ImageBuket::COMPANY->value,
                ImageDirectory::VARIANT->value
            );

            $validated['image'] = $result->filename ?? null;
        }

        $this->productimagerepository->updateById($id, $validated);
        return $this->productimagerepository->findById($id);
    }

    public function delete(int $id): void
    {
        $product = $this->productimagerepository->findById($id);

        if(!$product) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product_image')
            ]));
        }

        $this->productimagerepository->deleteById($id);
    }
}
