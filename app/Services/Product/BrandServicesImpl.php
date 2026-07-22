<?php

namespace App\Services\Product;

// use App\DTO\PaginationDTO;
use App\Enums\ImageBuket;
use App\Enums\ImageDirectory;
use App\Enums\Status;
use App\Exceptions\DuplicateExcept;
use App\Exceptions\NotFoundExcept;
use App\Helpers\CustomValidator;
use App\Helpers\HelperMedia;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Contracts\BrandRepository;
use App\Services\Contracts\BrandService;
use Illuminate\Http\Request;

class BrandServicesImpl implements BrandService
{
    public function __construct(
        protected BrandRepository $brandrepository,
        protected CustomValidator $validator,
    ) {}

    private function brandValidator(array $data)
    {
        $rules = [
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'logo'        => 'nullable',
            'status'      => 'nullable' ?? Status::ACTIVE->value,
            'sort_order'  => 'nullable|integer',
            'link'        => 'nullable|string|max:255',
        ];
        return $this->validator->validate($data, $rules);
    }

    public function getAllBrand()
    {
        return $this->brandrepository->getAll();
    }

    public function getBrandById(array $data, int $id): mixed
    {
        $brand = $this->brandrepository->findById($id, select: ['id', 'name']);

        if (!$brand) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.brand')
            ]));
        }

        return $brand;
    }

    public function create(Request $request): Model
    {
        // 1. Validate text fields from the request
        $validated = $this->brandValidator($request->all());

        // 2. Handle logo upload separately (files are NOT in $request->all())
        $logoFile = $request->file('logo');
        if ($logoFile) {
            $result = HelperMedia::saveImageFileOrBase64(
                $logoFile,
                ImageBuket::COMPANY->value,
                ImageDirectory::BRAND->value
            );

            $validated['logo'] = $result->filename ?? null;
        }

        // 3. Persist and return the created model
        return $this->brandrepository->create($validated);
    }

    public function updateBrandById(Request $request, int $id): mixed
    {
        // 1. Make sure brand exists
        $brand = $this->brandrepository->findById($id);

        if (!$brand) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.brand')
            ]));
        }

        // 2. Validate text fields
        $validated = $this->brandValidator($request->all());

        // 3. Duplicate name check (exclude current record)
        if ($this->brandrepository->checkDuplicateColumn(['name' => $validated['name']], $id, true)) {
            throw new DuplicateExcept(__('messages.duplicated_name', [
                'info' => __('general.brand')
            ]));
        }

        // 4. Handle logo upload
        $logoFile = $request->file('logo');
        if ($logoFile) {
            // Delete the old logo file from disk before saving the new one
            if (!empty($brand->logo)) {
                HelperMedia::deleteUploadedFile(
                    'image',
                    ImageBuket::COMPANY->value,
                    ImageDirectory::BRAND->value,
                    $brand->logo
                );
            }

            $result = HelperMedia::saveUploadedFile(
                $logoFile,
                'image',
                ImageBuket::COMPANY->value,
                ImageDirectory::BRAND->value
            );

            $validated['logo'] = $result->filename ?? null;
        }
        // If no new file uploaded, 'logo' key is simply absent from $validated
        // so updateById() will not overwrite the existing logo column

        // 5. Persist and return fresh model
        $this->brandrepository->updateById($id, $validated);
        return $this->brandrepository->findById($id);
    }

    public function delete(int $id): void
    {
        $brand = $this->brandrepository->findById($id);

        if (!$brand) {
            throw new NotFoundExcept(__('messages.not_found', [
                'info' => __('general.brand')
            ]));
        }
        $this->brandrepository->deleteById($id);
    }

}
