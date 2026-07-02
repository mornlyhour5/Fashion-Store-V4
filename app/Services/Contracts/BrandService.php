<?php

namespace App\Services\Contracts;

use App\DTO\PaginationDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface BrandService
{
    /**
     * Get all brand data
     */
    public function getAllBrand();

    /**
     * Get paginated list of brand with optional filters.
     *
     * @param array $filter
     * @param int $perpage
     * @return PaginationDTO
     */
    // public function getBrandPaginaftion(array $filters = []): PaginationDTO;

    /**
     * Get a Brand by ID
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function getBrandById(array $data, int $id): mixed;

    /**
     * Create a new brand and return the created model.
     *
     * @param array $data
     * @return model
     */
    public function create(Request $request): Model;

    /**
     * Update an existing brand by ID and return the updated model.
     */
    public function updateBrandById(Request $request, int $id): mixed;

    /**
     * Delete a brand by ID.
     */
    public function delete(int $id): void;
}
