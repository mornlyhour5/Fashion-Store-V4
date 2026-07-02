<?php

namespace App\Services\Product;

use App\Repository\Product\BrandRepo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class BrandServices
{
    public function __construct(protected BrandRepo $Brandrepository)
    {
        $this->Brandrepository = $Brandrepository;
    }

    public function getAll()
    {
        return $this->Brandrepository->getAll();
    }

    public function getWhereId($id)
    {
        return $this->Brandrepository->findId($id);
    }

    public function create(array $data, ?UploadedFile $logo = null)
    {
        $imagePath = null;

        if ($logo) {
            $imagePath = $logo->store('brands', 'public');
        }

        $payload = [
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'logo'        => $imagePath,
            'status'      => $data['status'] ?? 1,
            'sort_order'  => $data['sort_order'] ?? 1,
            'link' => $data['link'] ?? null,
        ];

        return $this->Brandrepository->create($payload);
    }

    public function update(int $id, array $data, ?UploadedFile $image = null)
    {
        $brand = $this->Brandrepository->findId($id);

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        // keep old image path by default
        // only replace if a new file was actually uploaded
        $imagePath = $brand->logo;

        if ($image) {
            // delete old file from storage before saving new one
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $imagePath = $image->store('brands', 'public');
        }

        $payload = [
            'name'        => $data['name'],
            'slug'        => $data['slug'] ?? Str::slug($data['name']),
            'description' => $data['description'] ?? $brand->description,
            'logo'        => $imagePath,                          // old path if no new image
            'status'      => $data['status'] ?? $brand->status,
            'sort_order'  => $data['sort_order'] ?? $brand->sort_order,
            'link'        => $data['link'] ?? $brand->link,
        ];

        return $this->Brandrepository->update($id, $payload);
    }

    public function delete($id)
    {
        $cart = $this->Brandrepository->findId($id);

        return $this->Brandrepository->delete($cart);
    }
}
