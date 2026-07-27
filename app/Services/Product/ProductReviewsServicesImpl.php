<?php

namespace App\Services\Product;

use App\Exceptions\NotFoundExcept;
use App\Repository\Contracts\ProductReviewsRepository;
use App\Services\Contracts\ProductReviewsService;

class ProductReviewsServicesImpl implements ProductReviewsService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected ProductReviewsRepository $reviews){}

    public function getAll()
    {
        return $this->reviews->getAll();
    }

    public function delete(int $id): void
    {
        $product = $this->reviews->findById($id);

        if(!$product) {
            throw new NotFoundExcept();
        }

        $this->reviews->deleteById($id);
    }
}
