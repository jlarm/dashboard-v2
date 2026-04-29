import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults, validateParameters } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
const IndividualCreateController = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IndividualCreateController.url(args, options),
    method: 'get',
})

IndividualCreateController.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived/create/{individualAudit?}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
IndividualCreateController.url = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { individualAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { individualAudit: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            individualAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    validateParameters(args, [
        "individualAudit",
    ])

    const parsedArgs = {
        individualAudit: typeof args?.individualAudit === 'object'
        ? args.individualAudit.id
        : args?.individualAudit,
    }

    return IndividualCreateController.definition.url
            .replace('{individualAudit?}', parsedArgs.individualAudit?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
IndividualCreateController.get = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IndividualCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
IndividualCreateController.head = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: IndividualCreateController.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
const IndividualCreateControllerForm = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: IndividualCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
IndividualCreateControllerForm.get = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: IndividualCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
IndividualCreateControllerForm.head = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: IndividualCreateController.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

IndividualCreateController.form = IndividualCreateControllerForm

export default IndividualCreateController