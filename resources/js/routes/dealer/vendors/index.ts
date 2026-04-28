import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
export const thankyou = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thankyou.url(options),
    method: 'get',
})

thankyou.definition = {
    methods: ["get","head"],
    url: '/vendors/thankyou',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
thankyou.url = (options?: RouteQueryOptions) => {
    return thankyou.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
thankyou.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thankyou.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
thankyou.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: thankyou.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
const thankyouForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: thankyou.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
thankyouForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: thankyou.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
thankyouForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: thankyou.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

thankyou.form = thankyouForm

const vendors = {
    thankyou: Object.assign(thankyou, thankyou),
}

export default vendors