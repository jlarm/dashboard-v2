import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
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

const vendors = {
    thankyou: Object.assign(thankyou, thankyou),
}

export default vendors