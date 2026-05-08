import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
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
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settings.url = (options?: RouteQueryOptions) => {
    return settings.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: settings.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
const settingsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settingsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::settings
* @see app/Http/Controllers/Tenant/CyrismaController.php:21
* @route '/scans/settings'
*/
settingsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

settings.form = settingsForm

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::update
* @see app/Http/Controllers/Tenant/CyrismaController.php:33
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
* @see app/Http/Controllers/Tenant/CyrismaController.php:33
* @route '/scans/settings'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::update
* @see app/Http/Controllers/Tenant/CyrismaController.php:33
* @route '/scans/settings'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::update
* @see app/Http/Controllers/Tenant/CyrismaController.php:33
* @route '/scans/settings'
*/
const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaController::update
* @see app/Http/Controllers/Tenant/CyrismaController.php:33
* @route '/scans/settings'
*/
updateForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

const CyrismaController = { settings, update }

export default CyrismaController