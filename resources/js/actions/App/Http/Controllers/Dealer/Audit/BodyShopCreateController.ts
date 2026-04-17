import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
const BodyShopCreateController = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: BodyShopCreateController.url(args, options),
    method: 'get',
})

BodyShopCreateController.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
BodyShopCreateController.url = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return BodyShopCreateController.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
BodyShopCreateController.get = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: BodyShopCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
BodyShopCreateController.head = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: BodyShopCreateController.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
const BodyShopCreateControllerForm = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: BodyShopCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
BodyShopCreateControllerForm.get = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: BodyShopCreateController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
BodyShopCreateControllerForm.head = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: BodyShopCreateController.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

BodyShopCreateController.form = BodyShopCreateControllerForm

export default BodyShopCreateController