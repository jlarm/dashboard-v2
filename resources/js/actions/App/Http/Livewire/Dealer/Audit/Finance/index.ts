import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
const Index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

Index.definition = {
    methods: ["get","head"],
    url: '/audits/finance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
Index.url = (options?: RouteQueryOptions) => {
    return Index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
Index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
Index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
const IndexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
IndexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
IndexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Index.form = IndexForm

export default Index