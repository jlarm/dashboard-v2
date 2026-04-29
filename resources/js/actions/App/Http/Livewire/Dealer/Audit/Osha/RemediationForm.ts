import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/RemediationForm.php:7
* @route '/audits/osha/{oshaViolationAudit}/remediation'
*/
const RemediationForm = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RemediationForm.url(args, options),
    method: 'get',
})

RemediationForm.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{oshaViolationAudit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/RemediationForm.php:7
* @route '/audits/osha/{oshaViolationAudit}/remediation'
*/
RemediationForm.url = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { oshaViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { oshaViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            oshaViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        oshaViolationAudit: typeof args.oshaViolationAudit === 'object'
        ? args.oshaViolationAudit.uuid
        : args.oshaViolationAudit,
    }

    return RemediationForm.definition.url
            .replace('{oshaViolationAudit}', parsedArgs.oshaViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/RemediationForm.php:7
* @route '/audits/osha/{oshaViolationAudit}/remediation'
*/
RemediationForm.get = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RemediationForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/RemediationForm.php:7
* @route '/audits/osha/{oshaViolationAudit}/remediation'
*/
RemediationForm.head = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RemediationForm.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/RemediationForm.php:7
* @route '/audits/osha/{oshaViolationAudit}/remediation'
*/
const RemediationFormForm = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RemediationForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/RemediationForm.php:7
* @route '/audits/osha/{oshaViolationAudit}/remediation'
*/
RemediationFormForm.get = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RemediationForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/RemediationForm.php:7
* @route '/audits/osha/{oshaViolationAudit}/remediation'
*/
RemediationFormForm.head = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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