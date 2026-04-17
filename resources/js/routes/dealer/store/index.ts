import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Store\CreateFirstStoreController::__invoke
* @see app/Http/Controllers/Dealer/Store/CreateFirstStoreController.php:15
* @route '/dashboard/first-store'
*/
export const first = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: first.url(options),
    method: 'post',
})

first.definition = {
    methods: ["post"],
    url: '/dashboard/first-store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\Store\CreateFirstStoreController::__invoke
* @see app/Http/Controllers/Dealer/Store/CreateFirstStoreController.php:15
* @route '/dashboard/first-store'
*/
first.url = (options?: RouteQueryOptions) => {
    return first.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Store\CreateFirstStoreController::__invoke
* @see app/Http/Controllers/Dealer/Store/CreateFirstStoreController.php:15
* @route '/dashboard/first-store'
*/
first.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: first.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\Store\CreateFirstStoreController::__invoke
* @see app/Http/Controllers/Dealer/Store/CreateFirstStoreController.php:15
* @route '/dashboard/first-store'
*/
const firstForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: first.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\Store\CreateFirstStoreController::__invoke
* @see app/Http/Controllers/Dealer/Store/CreateFirstStoreController.php:15
* @route '/dashboard/first-store'
*/
firstForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: first.url(options),
    method: 'post',
})

first.form = firstForm

/**
* @see \App\Http\Controllers\Dealer\StoreController::edit
* @see app/Http/Controllers/Dealer/StoreController.php:21
* @route '/edit'
*/
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\StoreController::edit
* @see app/Http/Controllers/Dealer/StoreController.php:21
* @route '/edit'
*/
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\StoreController::edit
* @see app/Http/Controllers/Dealer/StoreController.php:21
* @route '/edit'
*/
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\StoreController::edit
* @see app/Http/Controllers/Dealer/StoreController.php:21
* @route '/edit'
*/
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\StoreController::edit
* @see app/Http/Controllers/Dealer/StoreController.php:21
* @route '/edit'
*/
const editForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\StoreController::edit
* @see app/Http/Controllers/Dealer/StoreController.php:21
* @route '/edit'
*/
editForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\StoreController::edit
* @see app/Http/Controllers/Dealer/StoreController.php:21
* @route '/edit'
*/
editForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

const store = {
    first: Object.assign(first, first),
    edit: Object.assign(edit, edit),
}

export default store