import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/vendors/form',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

const VendorController = { show }

export default VendorController