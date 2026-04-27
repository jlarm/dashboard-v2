import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
const Show = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Show.url(args, options),
    method: 'get',
})

Show.definition = {
    methods: ["get","head"],
    url: '/logs/{activity}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
Show.url = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { activity: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { activity: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            activity: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        activity: typeof args.activity === 'object'
        ? args.activity.id
        : args.activity,
    }

    return Show.definition.url
            .replace('{activity}', parsedArgs.activity.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
Show.get = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
Show.head = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
const ShowForm = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
ShowForm.get = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
ShowForm.head = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Show.form = ShowForm

export default Show