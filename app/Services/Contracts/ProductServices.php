<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ProductServices
{
    public function getAllProduct();

    public function getProductById(array $data, int $id): mixed;

    public function create(Request $request): Model;

    public function update(Request $request, int $id): mixed;

    public function delete(int $id): void;

    public function implementData(array $data): mixed;

    public function getTrending(int $limit = 10): mixed;

    public function showBySlug(string $slug);
}
