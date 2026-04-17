import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
const Index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

Index.definition = {
    methods: ["get","head"],
    url: '/manuals/cms',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
Index.url = (options?: RouteQueryOptions) => {
    return Index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
Index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
Index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
const IndexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
IndexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
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