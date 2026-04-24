import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\FinanceCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/FinanceCreateController.php:14
* @route '/audits/finance/create/{store}'
*/
const FinanceCreateController = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: FinanceCreateController.url(args, options),
    method: 'get',
})

FinanceCreateController.definition = {
    methods: ["get","head"],
    url: '/audits/finance/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\FinanceCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/FinanceCreateController.php:14
* @route '/audits/finance/create/{store}'
*/
FinanceCreateController.url = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return FinanceCreateController.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\FinanceCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/FinanceCreateController.php:14
* @route '/audits/finance/create/{store}'
*/
FinanceCreateController.get = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: FinanceCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\FinanceCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/FinanceCreateController.php:14
* @route '/audits/finance/create/{store}'
*/
FinanceCreateController.head = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: FinanceCreateController.url(args, options),
    method: 'head',
})

export default FinanceCreateController