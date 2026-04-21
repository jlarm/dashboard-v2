import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Central\DealershipController::index
* @see app/Http/Controllers/Central/DealershipController.php:23
* @route '//dashboard.test/dealerships'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/dealerships',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\DealershipController::index
* @see app/Http/Controllers/Central/DealershipController.php:23
* @route '//dashboard.test/dealerships'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\DealershipController::index
* @see app/Http/Controllers/Central/DealershipController.php:23
* @route '//dashboard.test/dealerships'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DealershipController::index
* @see app/Http/Controllers/Central/DealershipController.php:23
* @route '//dashboard.test/dealerships'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\DealershipController::store
* @see app/Http/Controllers/Central/DealershipController.php:42
* @route '//dashboard.test/dealerships'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/dealerships',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\DealershipController::store
* @see app/Http/Controllers/Central/DealershipController.php:42
* @route '//dashboard.test/dealerships'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\DealershipController::store
* @see app/Http/Controllers/Central/DealershipController.php:42
* @route '//dashboard.test/dealerships'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const dealerships = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
}

export default dealerships