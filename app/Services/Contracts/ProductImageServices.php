<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ProductImageServices
{
    public function getAllProductImage(Request $request);

    public function getProductImageWhereId(Request $request, int $id): mixed;

    public function create(Request $request): Model;

    public function update(Request $request, int $id): Model;

    public function delete(int $id): void;
}
