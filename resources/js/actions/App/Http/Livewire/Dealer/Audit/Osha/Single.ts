import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Single.php:7
* @route '/audits/osha/{oshaViolationAudit}'
*/
const Single = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Single.url(args, options),
    method: 'get',
})

Single.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{oshaViolationAudit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Single.php:7
* @route '/audits/osha/{oshaViolationAudit}'
*/
Single.url = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return Single.definition.url
            .replace('{oshaViolationAudit}', parsedArgs.oshaViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Single.php:7
* @route '/audits/osha/{oshaViolationAudit}'
*/
Single.get = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Single.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Single.php:7
* @route '/audits/osha/{oshaViolationAudit}'
*/
Single.head = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Single.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Single.php:7
* @route '/audits/osha/{oshaViolationAudit}'
*/
const SingleForm = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Single.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Single.php:7
* @route '/audits/osha/{oshaViolationAudit}'
*/
SingleForm.get = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Single.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Single.php:7
* @route '/audits/osha/{oshaViolationAudit}'
*/
SingleForm.head = (args: { oshaViolationAudit: string | number | { uuid: string | number } } | [oshaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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