import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
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

const settings = {
    update: Object.assign(update, update),
}

export default settings