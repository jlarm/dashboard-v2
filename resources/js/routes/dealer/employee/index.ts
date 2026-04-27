import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonate
* @see app/Http/Controllers/Dealer/ImpersonationController.php:13
* @route '/employee/{user}/impersonate'
*/
export const impersonate = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: impersonate.url(args, options),
    method: 'get',
})

impersonate.definition = {
    methods: ["get","head"],
    url: '/employee/{user}/impersonate',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonate
* @see app/Http/Controllers/Dealer/ImpersonationController.php:13
* @route '/employee/{user}/impersonate'
*/
impersonate.url = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { user: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.id
        : args.user,
    }

    return impersonate.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonate
* @see app/Http/Controllers/Dealer/ImpersonationController.php:13
* @route '/employee/{user}/impersonate'
*/
impersonate.get = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: impersonate.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonate
* @see app/Http/Controllers/Dealer/ImpersonationController.php:13
* @route '/employee/{user}/impersonate'
*/
impersonate.head = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: impersonate.url(args, options),
    method: 'head',
})

const employee = {
    impersonate: Object.assign(impersonate, impersonate),
}

export default employee