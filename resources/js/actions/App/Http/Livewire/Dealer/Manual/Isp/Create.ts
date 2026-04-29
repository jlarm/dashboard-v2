import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
const Create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Create.url(options),
    method: 'get',
})

Create.definition = {
    methods: ["get","head"],
    url: '/manuals/isp/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
Create.url = (options?: RouteQueryOptions) => {
    return Create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
Create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
Create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
const CreateForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
CreateForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
CreateForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Create.form = CreateForm

export default Create