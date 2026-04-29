import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Store\CreateFirstStoreController::__invoke
* @see app/Http/Controllers/Dealer/Store/CreateFirstStoreController.php:15
* @route '/dashboard/first-store'
*/
const CreateFirstStoreController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: CreateFirstStoreController.url(options),
    method: 'post',
})

CreateFirstStoreController.definition = {
    methods: ["post"],
    url: '/dashboard/first-store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\Store\CreateFirstStoreController::__invoke
* @see app/Http/Controllers/Dealer/Store/CreateFirstStoreController.php:15
* @route '/dashboard/first-store'
*/
CreateFirstStoreController.url = (options?: RouteQueryOptions) => {
    return CreateFirstStoreController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Store\CreateFirstStoreController::__invoke
* @see app/Http/Controllers/Dealer/Store/CreateFirstStoreController.php:15
* @route '/dashboard/first-store'
*/
CreateFirstStoreController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: CreateFirstStoreController.url(options),
    method: 'post',
})

export default CreateFirstStoreController