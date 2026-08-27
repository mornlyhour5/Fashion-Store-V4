<?php

namespace App\Services\Product;

use App\Enums\FeaturedStatus;
use App\Enums\GenderProduct;
use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Enums\ProductStatus;
// use App\Enums\Status;
use App\Exceptions\DuplicateExcept;
use App\Exceptions\NotFoundExcept;
use App\Helpers\ApiResponse;
use App\Helpers\CustomValidator;
use App\Helpers\HelperMedia;
use App\Http\Resources\ProductResource;
use App\Repository\Contracts\ProductImageRepository;
use App\Repository\Contracts\ProductRepository;
use App\Repository\Contracts\ProductReviewsRepository;
use App\Repository\Contracts\ProductVariantRepository;
use App\Services\Contracts\ProductServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

class ProductServicesImpl implements ProductServices
{
    public function __construct(
        protected ProductRepository $productrepository,
        protected ProductVariantRepository $varaint,
        protected ProductImageRepository $productImage,
        protected ProductReviewsRepository $review,
        protected CustomValidator $validator,
    ) {}

    public function ProductValidator(array $data)
    {
        $rules = [
            'category_id'  => 'nullable|exists:categories,id',
            'name'         => 'required|string|max:255',
            'slug'         => 'nullable',
            'description'  => 'nullable|string',
            'brand_id'     => 'nullable|exists:brand,id',
            'base_price'   => 'nullable|numeric|min:0.01',
            'thumbnail'    => 'nullable',
            'views_count'  => 'nullable',
            'status'       => 'nullable' ?? ProductStatus::ACTIVE->value,
            'gender'       => 'nullable' ?? GenderProduct::UNISEX->value,
            'short_description' => 'nullable',
            'country_of_origin' => 'nullable',
            'material'      => 'nullable',
            // 'stock'        => 'nullable|integer|min:0',
            'weight'       => 'nullable',
            'is_featured'  => 'nullable' ?? FeaturedStatus::NOT_FEATURED->value,
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

        $imageFile = $request->file('thumbnail');
        if ($imageFile) {
            $result = HelperMedia::saveImageFileOrBase64(
                $imageFile,
                ImageBuket::COMPANY->value,
                ImageDirectory::PRODUCT->value
            );

            $validated['thumbnail'] = $result->filename ?? null;
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

        $imageFile = $request->file('thumbnail');
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
        $validated['thumbnail'] = $result->filename ?? null;
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

    public function implementData(array $data): mixed
    {
        throw new ('dkfjghdfg');
    }

    public function getTrending(int $limit = 10): mixed
    {
        $products = $this->productrepository->getTrending($limit);
        return ApiResponse::success(ProductResource::collection($products));
    }

    public function showBySlug(string $slug)
    {
        $product = $this->productrepository->findbyslug($slug);

        if (!$product) {
            throw new NotFoundExcept('Product not found');
        }

        $variants = $this->varaint->getVariantByProductID($product->id);
        $reviews = $this->review->getByProductID($product->id);

        return [
            ...$product->toArray(),
            'variants' => $variants,
            'reviews' => $reviews,
        ];
    }
}
