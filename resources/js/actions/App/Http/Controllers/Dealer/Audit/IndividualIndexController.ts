import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualIndexController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualIndexController.php:13
* @route '/audits/deal-jackets-archived'
*/
const IndividualIndexController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IndividualIndexController.url(options),
    method: 'get',
})

IndividualIndexController.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualIndexController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualIndexController.php:13
* @route '/audits/deal-jackets-archived'
*/
IndividualIndexController.url = (options?: RouteQueryOptions) => {
    return IndividualIndexController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualIndexController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualIndexController.php:13
* @route '/audits/deal-jackets-archived'
*/
IndividualIndexController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IndividualIndexController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualIndexController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualIndexController.php:13
* @route '/audits/deal-jackets-archived'
*/
IndividualIndexController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: IndividualIndexController.url(options),
    method: 'head',
})

export default IndividualIndexController