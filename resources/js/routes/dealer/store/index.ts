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
* @see \App\Http\Controllers\Tenant\Store\SwitchStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/SwitchStoreController.php:15
* @route '/current-store'
*/
export const switchMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: switchMethod.url(options),
    method: 'post',
})

switchMethod.definition = {
    methods: ["post"],
    url: '/current-store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Store\SwitchStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/SwitchStoreController.php:15
* @route '/current-store'
*/
switchMethod.url = (options?: RouteQueryOptions) => {
    return switchMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Store\SwitchStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/SwitchStoreController.php:15
* @route '/current-store'
*/
switchMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: switchMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Store\SwitchStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/SwitchStoreController.php:15
* @route '/current-store'
*/
const switchMethodForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: switchMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Store\SwitchStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/SwitchStoreController.php:15
* @route '/current-store'
*/
switchMethodForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: switchMethod.url(options),
    method: 'post',
})

switchMethod.form = switchMethodForm

const store = {
    first: Object.assign(first, first),
    switch: Object.assign(switchMethod, switchMethod),
}

export default store