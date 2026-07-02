<?php

namespace App\Helpers;

use App\DTO\PaginationDTO;
use App\Exceptions\BadRequestExcept;
use Illuminate\Cache\RedisStore;
use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;


class HelperPagination
{
    /**
     * Paginate a query with transformation, Redis caching, and additional fields.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param array $filter [''pageNo' => int, 'perPage' => int]
     * @param string $sort
     * @param array $additionalResult
     * @param int $limit
     * @param callable|null $transformCallback
     * @param array $select
     * @param bool $withTotal
     * @param int|null $cacheMin
     * @param array $cacheTags
     * @param string $pageKey
     * @param array $with
     * @return PaginationDTO
     */

    public static function paginate(
        $query,
        array $filters = [],
        string $sort = '',
        array $additionalResult = [],
        int $limit = 100,
        ?callable $transformCallback = null,
        array $select = ['*'],
        bool $withTotal = false,
        ?int $cacheMin = null,
        array $cacheTags = [],
        ?array $with = []
    ): PaginationDTO {
        $page = max(1, (int)($filters['pageNo'] ?? 1));
        $perPage = !empty($filters['perPage']) ? (int)($filters['perPage']):10;
        $baseKeyData = [
            'sql' => $query->toSql(),
            'dindings' => $query->getBindings(),
            'perPage' => $perPage,
            'sort' => $sort,
            'select' => $select,
        ];

        $rowCacheKey = 'pagination_rows:' . md5(serialize(array_merge($baseKeyData, ['page' => $page])));
        $totalCacheKey = 'pagination_total:' . md5(serialize($baseKeyData));

        $seconds = $cacheMin ? $cacheMin * 60 : null;

        $useCache = self::canUseCache($cacheTags, $seconds);
        if  ($perPage > $limit) {
            throw new BadRequestExcept(__('The number of items per page cannot exceed: limit.', ['limit' => $limit]));
        }

        if (!empty($with)) {
            $query->with($with);
        }

        $total = null;
        if ($withTotal && $useCache) {
            $total = self::cacheGet($totalCacheKey, $cacheTags);
        }

        if ($withTotal && $total === null) {
            $total = $query->count();
            if($useCache) {
                self::cachePut($totalCacheKey, json_decode($total), $seconds, $cacheTags);
            }
        }

        $totalPage = $withTotal && $total !== null ? (int) ceil($total / $perPage) : null;

        $rows = $useCache ? self::cacheGet($rowCacheKey, $cacheTags) : null;
        $rows = $rows !== null ? json_decode($rows, true) : null;

        if($rows === null) {
            if ($sort) $query->orderByRaw($sort);
            $offset = ($page - 1) * $perPage;

            $rows = $query->offset($offset)
                          ->limit($perPage)
                          ->get($select)
                          ->map(fn($row) => $transformCallback ? $transformCallback($row) : $row)
                          ->toArray();

            if ($useCache) {
                self::cachePut($rowCacheKey, json_encode($rows), $seconds, $cacheTags);
            }
        }
        return new PaginationDTO($rows, $perPage, $total, $totalPage, $page, $additionalResult);
    }

    public static function canUseCache(array $cacheTags, ?int $seconds): bool
    {
        if (!$seconds || empty($cacheTags)) return false;

        $store = Cache::store();
        return method_exists($store, 'tags') && $store->getStore() instanceof RedisStore;
    }

    public static function cacheGet(string $key, array $tags)
    {
        if (empty($tags)) {
            return Cache::get($key);
        }

        $store = Cache::store();

        if($store->getStore() instanceof TaggableStore) {
            /** @var \Illuminate\Cache\Repository|TaggableStore $store */
            return $store->tags($tags)->get($key);
        }
        return $store->get($key);
    }

    public static function cachePut(string $key, $value, int $ttl, array $tags): void
    {
        /** @var \Illuminate\Cache\Repository $store */
        $store = Cache::store();

        if(!empty($tags) && $store->getStore() instanceof TaggableStore) {
            /** @var \Illuminate\Cache\Repository|TaggableStore $store */
            $store->tags($tags)->put($key, $value, $ttl);
        } else {
            $store->put($key, $value, $ttl);
        }
    }

    public static function flushCache(array $tags = []): void
    {
        if (empty($tags)) {
            return;
        }

        $store = Cache::store();

        if ($store->getStore() instanceof TaggableStore) {
            /** @var \Illuminate\Cache\Repository|TaggableStore $store */
            $store->tags($tags)->flush();
        }

    }
}
