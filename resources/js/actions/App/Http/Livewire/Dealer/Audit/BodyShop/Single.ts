import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
const Single = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Single.url(args, options),
    method: 'get',
})

Single.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{bodyShopViolationAudit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
Single.url = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { bodyShopViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { bodyShopViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            bodyShopViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        bodyShopViolationAudit: typeof args.bodyShopViolationAudit === 'object'
        ? args.bodyShopViolationAudit.uuid
        : args.bodyShopViolationAudit,
    }

    return Single.definition.url
            .replace('{bodyShopViolationAudit}', parsedArgs.bodyShopViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
Single.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Single.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
Single.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Single.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
const SingleForm = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Single.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
SingleForm.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Single.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
SingleForm.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Single.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Single.form = SingleForm

export default Single