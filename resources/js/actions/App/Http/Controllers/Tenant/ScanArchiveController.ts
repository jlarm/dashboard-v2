import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::index
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/scans-archive',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::index
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::index
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::index
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:25
* @route '/scans-archive'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::upload
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:48
* @route '/scans-archive/upload'
*/
export const upload = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

upload.definition = {
    methods: ["post"],
    url: '/scans-archive/upload',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::upload
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:48
* @route '/scans-archive/upload'
*/
upload.url = (options?: RouteQueryOptions) => {
    return upload.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScanArchiveController::upload
* @see app/Http/Controllers/Tenant/ScanArchiveController.php:48
* @route '/scans-archive/upload'
*/
upload.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

const ScanArchiveController = { index, upload }

export default ScanArchiveController