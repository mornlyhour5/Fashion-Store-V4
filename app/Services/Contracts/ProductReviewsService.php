<?php

namespace App\Services\Contracts;

interface ProductReviewsService
{
    public function getAll();

    public function delete(int $id): void;
}
