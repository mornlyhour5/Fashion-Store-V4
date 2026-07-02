<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface CategoryServices
{
    public function getAllCategory();
    /**
     * Create a new category
     *
     * @param array $data
     * @return void
     */
    public function create(Request $request): Model;

    /**
     * Get a category by ID
     *
     * @param int $id
     * @return mixed
     */
    public function getCategoryById(int $id): mixed;

    /**
     * Update a existing category by ID
     *
     * @param array $data
     * @param int   $id
     * @return mixed
     */
    public function updateCategoryById(Request $request, int $id): mixed;

    /**
     * Delete a category by ID
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

}
