<?php

namespace App\Repository;

use App\Domain\AuthUser;
use App\DTO\PaginationDTO;
use App\Exceptions\NotFoundExcept;
use App\Helpers\HelperPagination;
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

    public function getAll(): Collection
    {
        return $this->model->whereNull('deleted_at')->get();
    }

    public function findById(int $id, array $select = ['*']): ?Model
    {
        return $this->model->select($select)->find($id);
    }

    public function findByIdWithConditions(int $id, array $select = ['*'], array $conditions = []): ?Model
    {
        $query = $this->model->select($select)->where('id', $id);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        return $query->first();
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

    public function query(array $select = ['*']): Builder
    {
        return $this->model->newQuery()->select($select);
    }

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
}
