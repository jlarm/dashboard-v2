import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Employee\DeletedIndex::__invoke
* @see app/Http/Livewire/Dealer/Employee/DeletedIndex.php:7
* @route '/employees/deleted'
*/
const DeletedIndex = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DeletedIndex.url(options),
    method: 'get',
})

DeletedIndex.definition = {
    methods: ["get","head"],
    url: '/employees/deleted',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Employee\DeletedIndex::__invoke
* @see app/Http/Livewire/Dealer/Employee/DeletedIndex.php:7
* @route '/employees/deleted'
*/
DeletedIndex.url = (options?: RouteQueryOptions) => {
    return DeletedIndex.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Employee\DeletedIndex::__invoke
* @see app/Http/Livewire/Dealer/Employee/DeletedIndex.php:7
* @route '/employees/deleted'
*/
DeletedIndex.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DeletedIndex.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Employee\DeletedIndex::__invoke
* @see app/Http/Livewire/Dealer/Employee/DeletedIndex.php:7
* @route '/employees/deleted'
*/
DeletedIndex.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: DeletedIndex.url(options),
    method: 'head',
})

export default DeletedIndex