import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Edit.php:7
* @route '/audits/osha/{oshaViolationAudit}/edit'
*/
const Edit = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Edit.url(args, options),
    method: 'get',
})

Edit.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{oshaViolationAudit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Edit.php:7
* @route '/audits/osha/{oshaViolationAudit}/edit'
*/
Edit.url = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return Edit.definition.url
            .replace('{oshaViolationAudit}', parsedArgs.oshaViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Edit.php:7
* @route '/audits/osha/{oshaViolationAudit}/edit'
*/
Edit.get = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Edit.php:7
* @route '/audits/osha/{oshaViolationAudit}/edit'
*/
Edit.head = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Edit.url(args, options),
    method: 'head',
})

export default Edit