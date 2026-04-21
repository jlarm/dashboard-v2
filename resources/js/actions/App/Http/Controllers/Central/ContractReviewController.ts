import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
export const show = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contract/view/{contract}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
show.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
show.get = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
show.head = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
const showForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
showForm.get = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::show
* @see app/Http/Controllers/Central/ContractReviewController.php:21
* @route '//dashboard.test/contract/view/{contract}'
*/
showForm.head = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

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

/**
* @see \App\Http\Controllers\Central\ContractReviewController::store
* @see app/Http/Controllers/Central/ContractReviewController.php:68
* @route '//dashboard.test/contract/view/{contract}'
*/
const storeForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractReviewController::store
* @see app/Http/Controllers/Central/ContractReviewController.php:68
* @route '//dashboard.test/contract/view/{contract}'
*/
storeForm.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

const ContractReviewController = { show, store }

export default ContractReviewController