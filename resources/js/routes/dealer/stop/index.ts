import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
export const impersonation = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: impersonation.url(options),
    method: 'get',
})

impersonation.definition = {
    methods: ["get","head"],
    url: '/stop-impersonation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
impersonation.url = (options?: RouteQueryOptions) => {
    return impersonation.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
impersonation.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: impersonation.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
impersonation.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: impersonation.url(options),
    method: 'head',
})

const stop = {
    impersonation: Object.assign(impersonation, impersonation),
}

export default stop