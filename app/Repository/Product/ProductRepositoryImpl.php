<?php

namespace App\Repository\Product;

use App\Models\Products;
use App\Repository\BaseRepositoryImpl;
use App\Repository\Contracts\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductRepositoryImpl extends BaseRepositoryImpl implements ProductRepository
{
    public function __construct(private Products $products)
    {
        $this->model = $products;
    }

    public function getTrending(int $limit = 10, int $days = 30): Collection
    {
        return $this->model->newQuery()
            ->with(['variants' => function ($q) {
                $q->whereNull('deleted_at')->with(['Images' => function ($iq) {
                    $iq->orderByDesc('is_main');
                }]);
            }])
            ->withCount(['reviews as recent_review_count' => function ($q) use ($days) {
                $q->where('created_at', '>=', now()->subDays($days));
            }])
            ->withAvg('reviews as avg_rating', 'rating')
            ->whereNull('deleted_at')
            ->orderByDesc('recent_review_count')
            ->orderByDesc('avg_rating')
            ->limit($limit)
            ->get();
    }
}
