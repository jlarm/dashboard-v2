import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:26
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
* @see app/Http/Controllers/Tenant/ScansController.php:26
* @route '/scans'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:26
* @route '/scans'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::index
* @see app/Http/Controllers/Tenant/ScansController.php:26
* @route '/scans'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:132
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
* @see app/Http/Controllers/Tenant/ScansController.php:132
* @route '/scans/external-finding'
*/
externalFinding.url = (options?: RouteQueryOptions) => {
    return externalFinding.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:132
* @route '/scans/external-finding'
*/
externalFinding.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: externalFinding.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\ScansController::externalFinding
* @see app/Http/Controllers/Tenant/ScansController.php:132
* @route '/scans/external-finding'
*/
externalFinding.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: externalFinding.url(options),
    method: 'head',
})

const ScansController = { index, externalFinding }

export default ScansController