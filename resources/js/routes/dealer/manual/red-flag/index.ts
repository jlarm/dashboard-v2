import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Index.php:7
* @route '/manuals/red-flag'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/manuals/red-flag',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Index.php:7
* @route '/manuals/red-flag'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Index.php:7
* @route '/manuals/red-flag'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Index.php:7
* @route '/manuals/red-flag'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Index.php:7
* @route '/manuals/red-flag'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Index.php:7
* @route '/manuals/red-flag'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Index.php:7
* @route '/manuals/red-flag'
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
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Create.php:7
* @route '/manuals/red-flag/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/manuals/red-flag/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Create.php:7
* @route '/manuals/red-flag/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Create.php:7
* @route '/manuals/red-flag/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Create.php:7
* @route '/manuals/red-flag/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Create.php:7
* @route '/manuals/red-flag/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Create.php:7
* @route '/manuals/red-flag/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\RedFlag\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/RedFlag/Create.php:7
* @route '/manuals/red-flag/create'
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

const redFlag = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
}

export default redFlag