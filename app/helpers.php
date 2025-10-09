<?php

use App\Helpers\CacheHelper;

if (! function_exists('tenant_cache_key')) {
    /**
     * Generate a tenant-specific cache key to prevent data leakage between tenants.
     *
     * @param  string  $key  The base cache key
     * @return string The tenant-prefixed cache key
     */
    function tenant_cache_key(string $key): string
    {
        return CacheHelper::tenantKey($key);
    }
}

if (! function_exists('tenant_cache_remember')) {
    /**
     * Remember a value in cache with tenant isolation.
     *
     * @param  DateTimeInterface|DateInterval|int|null  $ttl
     */
    function tenant_cache_remember(string $key, $ttl, Closure $callback): mixed
    {
        return CacheHelper::tenantRemember($key, $ttl, $callback);
    }
}

if (! function_exists('tenant_cache_forget')) {
    /**
     * Forget a value from cache with tenant isolation.
     */
    function tenant_cache_forget(string $key): bool
    {
        return CacheHelper::tenantForget($key);
    }
}
