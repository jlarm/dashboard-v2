import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
const Index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

Index.definition = {
    methods: ["get","head"],
    url: '/scans',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
Index.url = (options?: RouteQueryOptions) => {
    return Index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
Index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Tenant\Scans\Index::__invoke
* @see app/Http/Livewire/Tenant/Scans/Index.php:7
* @route '/scans'
*/
Index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Index.url(options),
    method: 'head',
})

export default Index