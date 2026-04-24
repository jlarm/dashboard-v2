import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Index.php:7
* @route '/manuals/osha'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/manuals/osha',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Index.php:7
* @route '/manuals/osha'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Index.php:7
* @route '/manuals/osha'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Index.php:7
* @route '/manuals/osha'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Index.php:7
* @route '/manuals/osha'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Index.php:7
* @route '/manuals/osha'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Index.php:7
* @route '/manuals/osha'
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

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Create.php:7
* @route '/manuals/osha/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/manuals/osha/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Create.php:7
* @route '/manuals/osha/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Create.php:7
* @route '/manuals/osha/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Create.php:7
* @route '/manuals/osha/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Create.php:7
* @route '/manuals/osha/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Create.php:7
* @route '/manuals/osha/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Osha\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Osha/Create.php:7
* @route '/manuals/osha/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

const osha = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
}

export default osha