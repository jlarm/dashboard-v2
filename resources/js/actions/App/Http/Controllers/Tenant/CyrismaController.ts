import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
export const settings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

settings.definition = {
    methods: ["get","head"],
    url: '/scans/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
settings.url = (options?: RouteQueryOptions) => {
    return settings.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
settings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:18
* @route '/scans/settings'
*/
settings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: settings.url(options),
    method: 'head',
})

const CyrismaController = { settings }

export default CyrismaController