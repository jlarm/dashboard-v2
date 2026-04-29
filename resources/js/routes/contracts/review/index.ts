import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\ContractReviewController::store
* @see app/Http/Controllers/Central/ContractReviewController.php:68
* @route '//dashboard.test/contract/view/{contract}'
*/
export const store = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/contract/view/{contract}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ContractReviewController::store
* @see app/Http/Controllers/Central/ContractReviewController.php:68
* @route '//dashboard.test/contract/view/{contract}'
*/
store.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return store.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractReviewController::store
* @see app/Http/Controllers/Central/ContractReviewController.php:68
* @route '//dashboard.test/contract/view/{contract}'
*/
store.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

const review = {
    store: Object.assign(store, store),
}

export default review