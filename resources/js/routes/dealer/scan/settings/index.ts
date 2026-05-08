import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
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

const settings = {
    update: Object.assign(update, update),
}

export default settings