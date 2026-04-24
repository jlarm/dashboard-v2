import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\UserController::store
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/employees/invite',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::store
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::store
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::store
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::store
* @see app/Http/Controllers/Tenant/UserController.php:115
* @route '/employees/invite'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const invite = {
    store: Object.assign(store, store),
}

export default invite