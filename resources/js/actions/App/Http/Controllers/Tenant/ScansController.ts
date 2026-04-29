import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:32
* @route '/scans'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/scans',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:32
* @route '/scans'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:32
* @route '/scans'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:32
* @route '/scans'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:177
* @route '/scans/external-finding'
*/
export const externalFinding = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: externalFinding.url(options),
    method: 'get',
})

externalFinding.definition = {
    methods: ["get","head"],
    url: '/scans/external-finding',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:177
* @route '/scans/external-finding'
*/
externalFinding.url = (options?: RouteQueryOptions) => {
    return externalFinding.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:177
* @route '/scans/external-finding'
*/
externalFinding.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: externalFinding.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:177
* @route '/scans/external-finding'
*/
externalFinding.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: externalFinding.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::queueReport
* @see app/Http/Controllers/Tenant/ScansController.php:138
* @route '/scans/queue-report'
*/
export const queueReport = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: queueReport.url(options),
    method: 'post',
})

queueReport.definition = {
    methods: ["post"],
    url: '/scans/queue-report',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::queueReport
* @see app/Http/Controllers/Tenant/ScansController.php:138
* @route '/scans/queue-report'
*/
queueReport.url = (options?: RouteQueryOptions) => {
    return queueReport.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::queueReport
* @see app/Http/Controllers/Tenant/ScansController.php:138
* @route '/scans/queue-report'
*/
queueReport.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: queueReport.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::refreshCache
* @see app/Http/Controllers/Tenant/ScansController.php:165
* @route '/scans/refresh-cache'
*/
export const refreshCache = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: refreshCache.url(options),
    method: 'post',
})

refreshCache.definition = {
    methods: ["post"],
    url: '/scans/refresh-cache',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\ScansController::refreshCache
* @see app/Http/Controllers/Tenant/ScansController.php:165
* @route '/scans/refresh-cache'
*/
refreshCache.url = (options?: RouteQueryOptions) => {
    return refreshCache.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::refreshCache
* @see app/Http/Controllers/Tenant/ScansController.php:165
* @route '/scans/refresh-cache'
*/
refreshCache.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: refreshCache.url(options),
    method: 'post',
})

const ScansController = { index, externalFinding, queueReport, refreshCache }

export default ScansController