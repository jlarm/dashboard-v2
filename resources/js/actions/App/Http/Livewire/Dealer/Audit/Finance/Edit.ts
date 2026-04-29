import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Edit.php:7
* @route '/audits/finance/{glbaViolationAudit}/edit'
*/
const Edit = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Edit.url(args, options),
    method: 'get',
})

Edit.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{glbaViolationAudit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Edit.php:7
* @route '/audits/finance/{glbaViolationAudit}/edit'
*/
Edit.url = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return Edit.definition.url
            .replace('{glbaViolationAudit}', parsedArgs.glbaViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Edit.php:7
* @route '/audits/finance/{glbaViolationAudit}/edit'
*/
Edit.get = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Edit.php:7
* @route '/audits/finance/{glbaViolationAudit}/edit'
*/
Edit.head = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Edit.url(args, options),
    method: 'head',
})

export default Edit