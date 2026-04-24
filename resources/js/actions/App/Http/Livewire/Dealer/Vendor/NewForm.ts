import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
const NewForm = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: NewForm.url(options),
    method: 'get',
})

NewForm.definition = {
    methods: ["get","head"],
    url: '/form',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
NewForm.url = (options?: RouteQueryOptions) => {
    return NewForm.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
NewForm.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: NewForm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
NewForm.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: NewForm.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
const NewFormForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: NewForm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
NewFormForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: NewForm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
NewFormForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: NewForm.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

NewForm.form = NewFormForm

export default NewForm