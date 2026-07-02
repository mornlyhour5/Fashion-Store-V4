<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ProductServices
{
    public function getAllProduct();

    public function getProductById(array $data, int $id): mixed;

    public function create(Request $request): Model;

    /**
     * Update an existing product by ID and return the update model.
     */
    public function update(Request $request, int $id): mixed;

    /**
     * Delete a product by ID.
     */
    public function delete(int $id): void;
}
