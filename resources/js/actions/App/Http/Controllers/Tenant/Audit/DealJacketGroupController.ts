import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketGroupController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketGroupController.php:13
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
export const show = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketGroupController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketGroupController.php:13
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealJacketGroup: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { dealJacketGroup: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
    }

    return show.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketGroupController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketGroupController.php:13
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketGroupController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketGroupController.php:13
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketGroupController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketGroupController.php:13
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
const showForm = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketGroupController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketGroupController.php:13
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
showForm.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketGroupController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketGroupController.php:13
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
showForm.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const DealJacketGroupController = { show }

export default DealJacketGroupController