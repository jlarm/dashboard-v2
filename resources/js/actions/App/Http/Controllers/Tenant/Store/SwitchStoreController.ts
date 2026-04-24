import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Store\SwitchStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/SwitchStoreController.php:15
* @route '/current-store'
*/
const SwitchStoreController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: SwitchStoreController.url(options),
    method: 'post',
})

SwitchStoreController.definition = {
    methods: ["post"],
    url: '/current-store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Store\SwitchStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/SwitchStoreController.php:15
* @route '/current-store'
*/
SwitchStoreController.url = (options?: RouteQueryOptions) => {
    return SwitchStoreController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Store\SwitchStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/SwitchStoreController.php:15
* @route '/current-store'
*/
SwitchStoreController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: SwitchStoreController.url(options),
    method: 'post',
})

export default SwitchStoreController