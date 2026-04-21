import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Docs\Index::__invoke
* @see app/Http/Livewire/Dealer/Docs/Index.php:7
* @route '/documents'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/documents',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Docs\Index::__invoke
* @see app/Http/Livewire/Dealer/Docs/Index.php:7
* @route '/documents'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Docs\Index::__invoke
* @see app/Http/Livewire/Dealer/Docs/Index.php:7
* @route '/documents'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Docs\Index::__invoke
* @see app/Http/Livewire/Dealer/Docs/Index.php:7
* @route '/documents'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const doc = {
    index: Object.assign(index, index),
}

export default doc