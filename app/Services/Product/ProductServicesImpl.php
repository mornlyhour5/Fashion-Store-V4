<?php

namespace App\Services\Product;

use App\Enums\GenderProduct;
use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Enums\ProductStatus;
use App\Exceptions\DuplicateExcept;
use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Helpers\HelperMedia;
use App\Repository\Contracts\ProductRepository;
use App\Services\Contracts\ProductServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductServicesImpl implements ProductServices
{
    public function __construct(
        protected ProductRepository $productrepository,
        protected CustomValidator $validator,
    ) {}

    public function ProductValidator(array $data)
    {
        $rules = [
            'category_id'  => 'nullable|exists:categories,id',
            'name'         => 'required|string|max:255',
            'slug'         => 'nullable',
            'base_price'   => 'nullable|numeric|min:0.01',
            'stock'        => 'nullable|integer|min:0',
            'description'  => 'nullable|string',
            'brand'        => 'nullable|string|max:100',
            'size'         => 'nullable|string|max:50',
            'gender'       => 'nullable' ?? GenderProduct::UNISEX->value,
            'image'        => 'nullable',
            'status'       => 'nullable' ?? ProductStatus::ACTIVE->value,
        ];
        return $this->validator->validate($data, $rules);
    }


    public function getAllProduct()
    {
        return $this->productrepository->getAll();
    }


    public function getProductById(array $data, int $id): mixed
    {
        $product = $this->productrepository->findById($id, select:  ['id', 'name']);

        if (!$product) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product')
            ]));
        }
        return $product;
    }

    public function create(Request $request): Model
    {
        $validated = $this->ProductValidator($request->all());

        $imageFile = $request->file('image');
        if ($imageFile) {
            $result = HelperMedia::saveImageFileOrBase64(
                $imageFile,
                'image',
                ImageBuket::COMPANY->value,
                ImageDirectory::PRODUCT->value
            )->filename;

            $validated['image'] = $result->filename ?? null;
        }

        return $this->productrepository->create($validated);
    }


    public function update(Request $request, int $id): mixed
    {
        $product = $this->productrepository->findById($id);

        if (!$product) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product')
            ]));
        }

        $validated = $this->ProductValidator($request->all());

        if ($this->productrepository->checkDuplicateColumn(['name' => $validated['name']], $id, true)) {
            throw new DuplicateExcept(__('messages.duplicated_name', [
                'info' => __('general.product')
            ]));
        }

        $imageFile = $request->file('image');
        if ($imageFile) {
            if (!empty($product->image)) {
                HelperMedia::deleteUploadedFile(
                    'image',
                    ImageBuket::COMPANY->value,
                    ImageDirectory::PRODUCT->value,
                    $product->image
                );

            }

            $result = HelperMedia::saveUploadedFile(
                $imageFile,
                'image',
                ImageBuket::COMPANY->value,
                ImageDirectory::PRODUCT->value
            );
        $validated['image'] = $result->filename ?? null;
        }
        $this->productrepository->updateById($id, $validated);
        return $this->productrepository->findById($id);
    }


    public function delete(int $id): void
    {
        $product = $this->productrepository->findById($id);

        if (!$product) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.product')
            ]));
        }

        $this->productrepository->deleteById($id);
        //     ->softDeleteById(
        //         id: $id,
        //         callback: function ($model) {
        //             if (!empty($model->image)) {
        //                 HelperMedia::deleteUploadedFile(
        //                     'image',
        //                     ImageBuket::COMPANY->value,
        //                     ImageDirectory::BRAND->value,
        //                     $model->image
        //                 );
        //             }
        //         }
        //     );

    }
}
