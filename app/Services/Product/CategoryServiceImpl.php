<?php

namespace App\Services\Product;

use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Exceptions\DuplicateExcept;
use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Helpers\HelperMedia;
use App\Repository\Contracts\CategoryRepository;
use App\Services\Contracts\CategoryServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use function PHPUnit\Framework\throwException;

class CategoryServiceImpl implements CategoryServices
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CategoryRepository $categoryrepository,
        protected CustomValidator $validator,
    ) {}

    private function categoryValidator(array $data)
    {
        $rules = [
            'name'       => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255',
            'parent_id'  => 'nullable|exists:categories,id',
            'status'     => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            // 'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image'      => 'nullable',
        ];
        return $this->validator->validate($data, $rules);
    }

    public function getAllCategory()
    {
        return $this->categoryrepository->getAll();
    }

    public function create(Request $request): Model
    {
        $validated = $this->categoryValidator($request->all());

        $imageFile = $request->file('image');
        if ($imageFile) {
            $result = HelperMedia::saveImageFileOrBase64(
                $imageFile,
                'image',
                ImageBuket::COMPANY->value,
                ImageDirectory::CATEGORIES->value
            )->filename;

            $validated['image'] = $result->filename ?? null;
        }

        return $this->categoryrepository->create($validated);
    }

    public function getCategoryById(int $id): mixed
    {
        $category = $this->categoryrepository->findById($id, select: [
            'id', 'name'
        ]);

        if (!$category) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.category')
            ]));
        }
        return $category;
    }

    public function updateCategoryById(Request $request, int $id): mixed
    {
        $category = $this->categoryrepository->findById($id);

        if (!$category) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.category')
            ]));
        }

        $validated = $this->categoryValidator($request->all());

        if ($this->categoryrepository->checkDuplicateColumn(['name' => $validated['name']], $id, true)) {
            throw new DuplicateExcept(__('messages.duplicated_name', [
                'info' => __('general.category')
            ]));
        }

        $imageFile = $request->file('image');
        if($imageFile) {
            if (!empty($category->image)) {
                HelperMedia::deleteUploadedFile(
                    'image',
                    ImageBuket::COMPANY->value,
                    ImageDirectory::CATEGORIES->value,
                    $category->image
                );
            }

            $result = HelperMedia::saveUploadedFile(
                $imageFile,
                'image',
                ImageBuket::COMPANY->value,
                ImageDirectory::CATEGORIES->value
            );
            $validated['image'] = $result->filename ?? null;
        }

        $this->categoryrepository->updateById($id, $validated);

        return $this->categoryrepository->findById($id); // ← actually return it
    }

    public function delete(int $id): void
    {
        $category = $this->categoryrepository->findById($id);

        if (!$category) {
            throw new NotFoundExcept(__('message.not_found', [
                'info' => __('general.category')
            ]));
        }
        $this->categoryrepository->deleteById($id);
    }
}
