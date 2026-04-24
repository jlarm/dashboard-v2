import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\SingleIndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/SingleIndividualController.php:17
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
const SingleIndividualController = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SingleIndividualController.url(args, options),
    method: 'get',
})

SingleIndividualController.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived/{individualAudit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\SingleIndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/SingleIndividualController.php:17
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
SingleIndividualController.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return SingleIndividualController.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\SingleIndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/SingleIndividualController.php:17
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
SingleIndividualController.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SingleIndividualController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\SingleIndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/SingleIndividualController.php:17
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
SingleIndividualController.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SingleIndividualController.url(args, options),
    method: 'head',
})

export default SingleIndividualController