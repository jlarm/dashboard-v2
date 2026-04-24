import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
const Index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

Index.definition = {
    methods: ["get","head"],
    url: '/phishing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
Index.url = (options?: RouteQueryOptions) => {
    return Index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
Index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
Index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Index.url(options),
    method: 'head',
})

export default Index