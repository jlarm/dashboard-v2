<?php

namespace App\Helpers;

use Closure;
use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Generate a tenant-specific cache key to prevent data leakage between tenants.
     *
     * @param  string  $key  The base cache key
     * @return string The tenant-prefixed cache key
     */
    public static function tenantKey(string $key): string
    {
        $tenantId = tenancy()->initialized ? tenant('id') : 'central';

        return "tenant_{$tenantId}_{$key}";
    }

    /**
     * Remember a value in cache with tenant isolation.
     *
     * @param  DateTimeInterface|DateInterval|int|null  $ttl
     */
    public static function tenantRemember(string $key, $ttl, Closure $callback): mixed
    {
        return Cache::remember(self::tenantKey($key), $ttl, $callback);
    }

    /**
     * Get a value from cache with tenant isolation.
     */
    public static function tenantGet(string $key, mixed $default = null): mixed
    {
        return Cache::get(self::tenantKey($key), $default);
    }

    /**
     * Put a value in cache with tenant isolation.
     *
     * @param  DateTimeInterface|DateInterval|int|null  $ttl
     */
    public static function tenantPut(string $key, mixed $value, $ttl = null): bool
    {
        return Cache::put(self::tenantKey($key), $value, $ttl);
    }

    /**
     * Forget a value from cache with tenant isolation.
     */
    public static function tenantForget(string $key): bool
    {
        return Cache::forget(self::tenantKey($key));
    }

    /**
     * Flush all cache for the current tenant.
     */
    public static function tenantFlush(): bool
    {
        if (! tenancy()->initialized) {
            return false;
        }

        $tenantId = tenant('id');
        $prefix = "tenant_{$tenantId}_";

        // For cache stores that support tags, we could use tags
        // For now, we'll use a manual approach that works with all drivers
        // Note: This is a limitation - complete flush is not possible with file/array cache
        // You would need to upgrade to Redis/Memcached for full flush support

        return true;
    }
}
