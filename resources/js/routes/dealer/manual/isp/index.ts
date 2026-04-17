import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Index.php:7
* @route '/manuals/isp'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/manuals/isp',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Index.php:7
* @route '/manuals/isp'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Index.php:7
* @route '/manuals/isp'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Index.php:7
* @route '/manuals/isp'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Index.php:7
* @route '/manuals/isp'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Index.php:7
* @route '/manuals/isp'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Index.php:7
* @route '/manuals/isp'
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
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/manuals/isp/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Isp\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Isp/Create.php:7
* @route '/manuals/isp/create'
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

const isp = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
}

export default isp