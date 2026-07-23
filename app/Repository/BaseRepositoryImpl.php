<?php

namespace App\Repository;

use App\Domain\AuthUser;
use App\DTO\PaginationDTO;
use App\Exceptions\NotFoundExcept;
use App\Exceptions\UnauthExcept;
use App\Helpers\Helper;
use App\Helpers\HelperPagination;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

// abstract class BaseRepositoryImpl implements BaseRepository
// {

//     protected ?AuthUser $actingUser = null;

//     public function __construct(protected Model $model) {}

//     public function findByIdWithConditions(int $id, array $select = ['*'], array $conditions = []): ?Model
//     {
//         $query = $this->model->select($select)->where('id', $id);

//         foreach ($conditions as $column => $value) {
//             $query->where($column, $value);
//         }

//         return $query->first();
//     }
// }




abstract class BaseRepositoryImpl implements BaseRepository
{
    protected ?AuthUser $actingUser = null;

    public function __construct(protected Model $model) {}

    // public function findByIdWithConditions(int $id, array $select = ['*'], array $conditions = []): ?Model
    // {
    //     $query = $this->model->select($select)->where('id', $id);

    //     foreach ($conditions as $column => $value) {
    //         $query->where($column, $value);
    //     }

    //     return $query->first();
    // }

    public function updateProfileByUserId(int $userId, array $data)
    {
        return \App\Models\Customers::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }

    public function getAll(): Collection
    {
        return $this->model->whereNull('deleted_at')->get();
    }

    public function getUser(array $filters = [])
    {
        $query = $this->model->newQuery();

        // Always show only Staff and Customers
        $query->whereIn('role', [3]);

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                ->orWhere('email', 'ILIKE', "%{$search}%");
            });
        }

        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }

    public function findById(int $id, array $select = ['*']): ?Model
    {
        return $this->model->select($select)->find($id);
    }

    public function findByIduser(int $id, array $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    public function findByIdWithConditions(int $id, array $select = ['*'], array $conditions = []): ?Model
    {
        $query = $this->model->select($select)->where('id', $id);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        return $query->first();
    }

    public function getStaff(array $filters = [])
    {
        $query = $this->model->newQuery();

        $query->where('role', \App\Enums\Role::STAFF->value); // role = 2 only

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                ->orWhere('email', 'ILIKE', "%{$search}%");
            });
        }

        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }

    public function getByVariant(int $variantId): Collection
    {
        return $this->model->where('product_variant_id', $variantId)
            ->orderBy('sort_order')
            ->get();
    }

    public function setActingUser(?AuthUser $user): static
    {
        $this->actingUser = $user;
        return $this;
    }

    public function countByVariant(int $variantId)
    {
        return $this->model->where('product_variant_id', $variantId)->count();
    }

    public function clearMainForVariant(int $variantId)
    {
        return $this->model->where('product_variant_id', $variantId)->update(['is_main' => false]);
    }

    public function bulkInsert(array $rows): bool
    {
        if(!$this->actingUser) {
            throw new UnauthExcept();
        }
        Helper::mergeIntoEach($rows, [
            'created_at' => now()
        ]);
        return $this->model->insert($rows);
    }

    public function lastId()
    {
        return $this->model
        ->newQuery()
        ->lockForUpdate()
        ->latest('order_number')
        ->first();
    }

    public function query(array $select = ['*']): Builder
    {
        return $this->model->newQuery()->select($select);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model
            ->where('email', $email)
            ->whereNull('deleted_at')
            ->first();
    }

    public function updateById(int $id, array $data): ?Model
    {
        $record = $this->model->find($id);

        if (!$record) {
            throw new NotFoundExcept('Resource not found');
        }

        $record->update($data);

        return $record->fresh();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function deleteById(int $id): void
    {
        $record = $this->model->find($id);

        if (!$record) {
            throw new NotFoundExcept('Resource not found');
        }

        $record->delete();
    }

    public function checkDuplicateColumn(array $conditions, ?int $excludeId = null, bool $ignoreSoftDeleted = false): bool
    {
        $query = $this->model->newQuery();

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        if ($ignoreSoftDeleted && in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($this->model))) {
            $query->withTrashed();
        }

        return $query->exists();
    }

    // public function query(array $select = ['*']): Builder
    // {
    //     return $this->model->newQuery()->select($select);
    // }

    public function pagination(
        array $fileters,
        array $select = ['*'],
        ?array $conditions = ['deleted_at' => null],
        int $limit = 100,
        bool $withTotal = true,
        string $rawSort = '',
        ?callable $callbackFunc = null,
        array $additionalResult = [],
        ?int $cacheMin = 10,
        array $catchTage = [],
        ?array $with = [],
        ?callable $beforeQuery = null
    ): PaginationDTO {
        $query = $this->query($select);
        $limit = min($limit, 1000);
        $model = $query->get();

        if ($beforeQuery) {
            $beforeQuery($query);
        }

        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                if (method_exists($model, $column)) {
                    if ($value === 'exists') {
                        $query->whereHas($column);
                        continue;
                    }

                    if ($value === 'non_exists') {
                        $query->doesntHave($column);
                        continue;
                    }

                    if ($value instanceof Closure) {
                        $query->whereHas($column, $value);
                        continue;
                    }

                    if (is_array($value) && count($value) === 2) {
                        [$operator, $val] = $value;
                        $query->whereHas($column, function ($q) use ($operator, $val) {
                            $q->where('id', $operator, $val);
                        });
                        continue;
                    }
                }

                if ($value instanceof Closure) {
                    $query->where($value);
                } elseif (is_array($value) && count($value) === 2) {
                    [$operator, $val] = $value;
                    if (strtoupper($operator) === 'LIKE' || strtoupper($operator) === 'ILIKE') {
                        $val = "%{$val}%";
                    }

                    $query->where($column, $operator, $val);
                } elseif (is_array($value)) {
                    $query->whereIn($column, $value);
                } else {
                    $query->where($column, $value);
                }
            }
        }

        return HelperPagination::paginate(
            query: $query,
            filters: $fileters,
            sort: $rawSort,
            additionalResult: $additionalResult,
            limit: $limit,
            transformCallback: $callbackFunc,
            select: $select,
            withTotal: $withTotal,
            cacheMin: $cacheMin,
            cacheTags: $catchTage,
            with: $with
        );
    }


    public function pagination_wish(
        array $fileters,
        array $select = ['*'],
        ?array $conditions = [],
        int $limit = 100,
        bool $withTotal = true,
        string $rawSort = '',
        ?callable $callbackFunc = null,
        array $additionalResult = [],
        ?int $cacheMin = 10,
        array $catchTage = [],
        ?array $with = [],
        ?callable $beforeQuery = null
    ): PaginationDTO {
        return $this->pagination(
            fileters: $fileters,
            select: $select,
            conditions: $conditions,
            limit: $limit,
            withTotal: $withTotal,
            rawSort: $rawSort,
            callbackFunc: $callbackFunc,
            additionalResult: $additionalResult,
            cacheMin: $cacheMin,
            catchTage: $catchTage,
            with: $with,
            beforeQuery: $beforeQuery
        );
    }

    // public function updateupdateById(int $id, array $data, array $conditions = ['deleted_at' => null], $throwIfNotFound = 'Resource not found'): ?Model
    // {
    //     $record = $this->model->where('id', $id);

    //     foreach ($conditions as $column => $value) {
    //         $record->where($column, $value);
    //     }
    //     $record = $record->first();
    //     if (!$record) {
    //         throw new NotFoundExcept($throwIfNotFound);
    //     }
    //     $record->update($data);
    //     return $record;
    // }
    public function findByEmailWithConditions(string $email, array $select = ['*'], array $conditions = []): ?Model
    {
        $query = $this->model->select($select)->where('email', $email);

        foreach ($conditions as $column => $value) {
            if (is_null($value)) {
                $query->whereNull($column);
            } else {
                $query->where($column, $value);
            }
        }

        return $query->first();
    }

    public function findAllWithRelations(): Collection
    {
        return $this->model
            ->with([
                'customer:id,name,email',
                'customer.customerProfile:id,user_id,first_name,last_name,phone',
            ])
            ->withCount('orderItems')
            ->latest()
            ->get();
    }
}
