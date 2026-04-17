import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
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

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonate
* @see app/Http/Controllers/Dealer/ImpersonationController.php:13
* @route '/employee/{user}/impersonate'
*/
const impersonateForm = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: impersonate.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonate
* @see app/Http/Controllers/Dealer/ImpersonationController.php:13
* @route '/employee/{user}/impersonate'
*/
impersonateForm.get = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: impersonate.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::impersonate
* @see app/Http/Controllers/Dealer/ImpersonationController.php:13
* @route '/employee/{user}/impersonate'
*/
impersonateForm.head = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: impersonate.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

impersonate.form = impersonateForm

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::stopImpersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
export const stopImpersonation = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: stopImpersonation.url(options),
    method: 'get',
})

stopImpersonation.definition = {
    methods: ["get","head"],
    url: '/stop-impersonation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::stopImpersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
stopImpersonation.url = (options?: RouteQueryOptions) => {
    return stopImpersonation.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::stopImpersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
stopImpersonation.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: stopImpersonation.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::stopImpersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
stopImpersonation.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: stopImpersonation.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::stopImpersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
const stopImpersonationForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: stopImpersonation.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::stopImpersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
stopImpersonationForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: stopImpersonation.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\ImpersonationController::stopImpersonation
* @see app/Http/Controllers/Dealer/ImpersonationController.php:44
* @route '/stop-impersonation'
*/
stopImpersonationForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: stopImpersonation.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

stopImpersonation.form = stopImpersonationForm

const ImpersonationController = { impersonate, stopImpersonation }

export default ImpersonationController