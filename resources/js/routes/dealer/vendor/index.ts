import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\VendorController::create
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/vendors/form',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::create
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::create
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::create
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::create
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::create
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::create
* @see app/Http/Controllers/Dealer/VendorController.php:18
* @route '/vendors/form'
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

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
export const form = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

form.definition = {
    methods: ["get","head"],
    url: '/form',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
form.url = (options?: RouteQueryOptions) => {
    return form.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
form.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
form.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: form.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
const formForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: form.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
formForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: form.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\NewForm::__invoke
* @see app/Http/Livewire/Dealer/Vendor/NewForm.php:7
* @route '/form'
*/
formForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: form.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

form.form = formForm

/**
* @see \App\Http\Livewire\Dealer\Vendor\Index::__invoke
* @see app/Http/Livewire/Dealer/Vendor/Index.php:7
* @route '/vendors'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/vendors',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Vendor\Index::__invoke
* @see app/Http/Livewire/Dealer/Vendor/Index.php:7
* @route '/vendors'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Vendor\Index::__invoke
* @see app/Http/Livewire/Dealer/Vendor/Index.php:7
* @route '/vendors'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\Index::__invoke
* @see app/Http/Livewire/Dealer/Vendor/Index.php:7
* @route '/vendors'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\Index::__invoke
* @see app/Http/Livewire/Dealer/Vendor/Index.php:7
* @route '/vendors'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\Index::__invoke
* @see app/Http/Livewire/Dealer/Vendor/Index.php:7
* @route '/vendors'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Vendor\Index::__invoke
* @see app/Http/Livewire/Dealer/Vendor/Index.php:7
* @route '/vendors'
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

const vendor = {
    create: Object.assign(create, create),
    form: Object.assign(form, form),
    index: Object.assign(index, index),
}

export default vendor