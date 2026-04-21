import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualController.php:16
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
const IndividualController = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IndividualController.url(args, options),
    method: 'get',
})

IndividualController.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived/{individualAudit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualController.php:16
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
IndividualController.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { individualAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { individualAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            individualAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        individualAudit: typeof args.individualAudit === 'object'
        ? args.individualAudit.uuid
        : args.individualAudit,
    }

    return IndividualController.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualController.php:16
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
IndividualController.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IndividualController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualController.php:16
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
IndividualController.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: IndividualController.url(args, options),
    method: 'head',
})

export default IndividualController