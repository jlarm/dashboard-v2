import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Store\CreateStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/CreateStoreController.php:14
* @route '/locations'
*/
const CreateStoreController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: CreateStoreController.url(options),
    method: 'post',
})

CreateStoreController.definition = {
    methods: ["post"],
    url: '/locations',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Store\CreateStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/CreateStoreController.php:14
* @route '/locations'
*/
CreateStoreController.url = (options?: RouteQueryOptions) => {
    return CreateStoreController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Store\CreateStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/CreateStoreController.php:14
* @route '/locations'
*/
CreateStoreController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: CreateStoreController.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Store\CreateStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/CreateStoreController.php:14
* @route '/locations'
*/
const CreateStoreControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: CreateStoreController.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Store\CreateStoreController::__invoke
* @see app/Http/Controllers/Tenant/Store/CreateStoreController.php:14
* @route '/locations'
*/
CreateStoreControllerForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: CreateStoreController.url(options),
    method: 'post',
})

CreateStoreController.form = CreateStoreControllerForm

export default CreateStoreController