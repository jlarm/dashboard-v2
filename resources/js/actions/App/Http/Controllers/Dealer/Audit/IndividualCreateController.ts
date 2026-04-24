import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults, validateParameters } from './../../../../../../wayfinder'
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

export default IndividualCreateController