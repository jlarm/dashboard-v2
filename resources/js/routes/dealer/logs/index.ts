import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Log\Index::__invoke
* @see app/Http/Livewire/Dealer/Log/Index.php:7
* @route '/logs'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/logs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Log\Index::__invoke
* @see app/Http/Livewire/Dealer/Log/Index.php:7
* @route '/logs'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Log\Index::__invoke
* @see app/Http/Livewire/Dealer/Log/Index.php:7
* @route '/logs'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Log\Index::__invoke
* @see app/Http/Livewire/Dealer/Log/Index.php:7
* @route '/logs'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
export const show = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/logs/{activity}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
show.url = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{activity}', parsedArgs.activity.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
show.get = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Log\Show::__invoke
* @see app/Http/Livewire/Dealer/Log/Show.php:7
* @route '/logs/{activity}'
*/
show.head = (args: { activity: string | number | { id: string | number } } | [activity: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const logs = {
    index: Object.assign(index, index),
    show: Object.assign(show, show),
}

export default logs