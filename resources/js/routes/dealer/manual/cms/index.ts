import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/manuals/cms',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Index::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Index.php:7
* @route '/manuals/cms'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Create.php:7
* @route '/manuals/cms/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/manuals/cms/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Create.php:7
* @route '/manuals/cms/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Create.php:7
* @route '/manuals/cms/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Manual\Cms\Create::__invoke
* @see app/Http/Livewire/Dealer/Manual/Cms/Create.php:7
* @route '/manuals/cms/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

const cms = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
}

export default cms