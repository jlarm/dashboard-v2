import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Livewire\Tenant\Audit\Fit\Index::__invoke
* @see app/Http/Livewire/Tenant/Audit/Fit/Index.php:7
* @route '/fit-tests'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/fit-tests',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Tenant\Audit\Fit\Index::__invoke
* @see app/Http/Livewire/Tenant/Audit/Fit/Index.php:7
* @route '/fit-tests'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Tenant\Audit\Fit\Index::__invoke
* @see app/Http/Livewire/Tenant/Audit/Fit/Index.php:7
* @route '/fit-tests'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Tenant\Audit\Fit\Index::__invoke
* @see app/Http/Livewire/Tenant/Audit/Fit/Index.php:7
* @route '/fit-tests'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const fitTests = {
    index: Object.assign(index, index),
}

export default fitTests