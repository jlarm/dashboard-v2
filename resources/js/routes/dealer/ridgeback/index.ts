import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Ridgeback\Index::__invoke
* @see app/Http/Livewire/Dealer/Ridgeback/Index.php:7
* @route '/ridgeback'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/ridgeback',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Ridgeback\Index::__invoke
* @see app/Http/Livewire/Dealer/Ridgeback/Index.php:7
* @route '/ridgeback'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Ridgeback\Index::__invoke
* @see app/Http/Livewire/Dealer/Ridgeback/Index.php:7
* @route '/ridgeback'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Ridgeback\Index::__invoke
* @see app/Http/Livewire/Dealer/Ridgeback/Index.php:7
* @route '/ridgeback'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Ridgeback\Index::__invoke
* @see app/Http/Livewire/Dealer/Ridgeback/Index.php:7
* @route '/ridgeback'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Ridgeback\Index::__invoke
* @see app/Http/Livewire/Dealer/Ridgeback/Index.php:7
* @route '/ridgeback'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Ridgeback\Index::__invoke
* @see app/Http/Livewire/Dealer/Ridgeback/Index.php:7
* @route '/ridgeback'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

const ridgeback = {
    index: Object.assign(index, index),
}

export default ridgeback