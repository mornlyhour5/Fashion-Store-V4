<?php
namespace App\Repository\Product;

use App\Models\Product_Variants;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\ProductVariantRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductVariantRepositoryImpl extends BaseRepositoryImpl implements ProductVariantRepository
{
    public function __construct(Product_Variants $variant)
    {
        parent::__construct($variant);
    }

    public function findById(int $id, array $select = ['*']): ?Model
    {
        return $this->model->with('productImages')->select($select)->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->with('productImages')->whereNull('deleted_at')->get();
    }
}
