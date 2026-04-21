import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Tenant\Audit\Fit\Index::__invoke
* @see app/Http/Livewire/Tenant/Audit/Fit/Index.php:7
* @route '/fit-tests'
*/
const Index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

Index.definition = {
    methods: ["get","head"],
    url: '/fit-tests',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Tenant\Audit\Fit\Index::__invoke
* @see app/Http/Livewire/Tenant/Audit/Fit/Index.php:7
* @route '/fit-tests'
*/
Index.url = (options?: RouteQueryOptions) => {
    return Index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Tenant\Audit\Fit\Index::__invoke
* @see app/Http/Livewire/Tenant/Audit/Fit/Index.php:7
* @route '/fit-tests'
*/
Index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Tenant\Audit\Fit\Index::__invoke
* @see app/Http/Livewire/Tenant/Audit/Fit/Index.php:7
* @route '/fit-tests'
*/
Index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Index.url(options),
    method: 'head',
})

export default Index