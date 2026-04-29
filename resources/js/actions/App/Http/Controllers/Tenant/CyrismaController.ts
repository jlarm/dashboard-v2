import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:19
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
* @see app/Http/Controllers/Tenant/CyrismaController.php:19
* @route '/scans/settings'
*/
settings.url = (options?: RouteQueryOptions) => {
    return settings.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:19
* @route '/scans/settings'
*/
settings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:19
* @route '/scans/settings'
*/
settings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: settings.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::update
* @see app/Http/Controllers/Tenant/CyrismaController.php:31
* @route '/scans/settings'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/scans/settings',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::update
* @see app/Http/Controllers/Tenant/CyrismaController.php:31
* @route '/scans/settings'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::update
* @see app/Http/Controllers/Tenant/CyrismaController.php:31
* @route '/scans/settings'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

const CyrismaController = { settings, update }

export default CyrismaController