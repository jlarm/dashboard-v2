import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
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
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
thankyou.url = (options?: RouteQueryOptions) => {
    return thankyou.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
thankyou.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thankyou.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
thankyou.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: thankyou.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
const thankyouForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: thankyou.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/vendors/thankyou'
*/
thankyouForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: thankyou.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
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