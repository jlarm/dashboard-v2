import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../../wayfinder'
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

export default Single