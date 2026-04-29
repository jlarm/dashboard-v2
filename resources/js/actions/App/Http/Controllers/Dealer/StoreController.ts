import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
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

const StoreController = { edit }

export default StoreController