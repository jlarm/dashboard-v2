import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php:7
* @route '/audits/finance/{glbaViolationAudit}/remediation'
*/
const RemediationForm = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RemediationForm.url(args, options),
    method: 'get',
})

RemediationForm.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{glbaViolationAudit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php:7
* @route '/audits/finance/{glbaViolationAudit}/remediation'
*/
RemediationForm.url = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { glbaViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { glbaViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            glbaViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        glbaViolationAudit: typeof args.glbaViolationAudit === 'object'
        ? args.glbaViolationAudit.uuid
        : args.glbaViolationAudit,
    }

    return RemediationForm.definition.url
            .replace('{glbaViolationAudit}', parsedArgs.glbaViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php:7
* @route '/audits/finance/{glbaViolationAudit}/remediation'
*/
RemediationForm.get = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RemediationForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php:7
* @route '/audits/finance/{glbaViolationAudit}/remediation'
*/
RemediationForm.head = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RemediationForm.url(args, options),
    method: 'head',
})

export default RemediationForm