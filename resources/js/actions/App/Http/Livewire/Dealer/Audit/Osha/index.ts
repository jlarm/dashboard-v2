import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Index.php:7
* @route '/audits/osha'
*/
const Index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

Index.definition = {
    methods: ["get","head"],
    url: '/audits/osha',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Index.php:7
* @route '/audits/osha'
*/
Index.url = (options?: RouteQueryOptions) => {
    return Index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Index.php:7
* @route '/audits/osha'
*/
Index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Osha/Index.php:7
* @route '/audits/osha'
*/
Index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Index.url(options),
    method: 'head',
})

export default Index