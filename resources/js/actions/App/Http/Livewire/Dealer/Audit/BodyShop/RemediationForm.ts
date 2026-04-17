import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
const RemediationForm = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RemediationForm.url(args, options),
    method: 'get',
})

RemediationForm.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{bodyShopViolationAudit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
RemediationForm.url = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return RemediationForm.definition.url
            .replace('{bodyShopViolationAudit}', parsedArgs.bodyShopViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
RemediationForm.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RemediationForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
RemediationForm.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RemediationForm.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
const RemediationFormForm = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RemediationForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
RemediationFormForm.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RemediationForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
RemediationFormForm.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RemediationForm.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RemediationForm.form = RemediationFormForm

export default RemediationForm