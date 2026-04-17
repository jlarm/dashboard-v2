import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\OshaCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/OshaCreateController.php:14
* @route '/audits/osha/create/{store}'
*/
const OshaCreateController = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: OshaCreateController.url(args, options),
    method: 'get',
})

OshaCreateController.definition = {
    methods: ["get","head"],
    url: '/audits/osha/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\OshaCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/OshaCreateController.php:14
* @route '/audits/osha/create/{store}'
*/
OshaCreateController.url = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: args.store,
    }

    return OshaCreateController.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\OshaCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/OshaCreateController.php:14
* @route '/audits/osha/create/{store}'
*/
OshaCreateController.get = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: OshaCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\OshaCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/OshaCreateController.php:14
* @route '/audits/osha/create/{store}'
*/
OshaCreateController.head = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: OshaCreateController.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\OshaCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/OshaCreateController.php:14
* @route '/audits/osha/create/{store}'
*/
const OshaCreateControllerForm = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: OshaCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\OshaCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/OshaCreateController.php:14
* @route '/audits/osha/create/{store}'
*/
OshaCreateControllerForm.get = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: OshaCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\OshaCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/OshaCreateController.php:14
* @route '/audits/osha/create/{store}'
*/
OshaCreateControllerForm.head = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: OshaCreateController.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

OshaCreateController.form = OshaCreateControllerForm

export default OshaCreateController