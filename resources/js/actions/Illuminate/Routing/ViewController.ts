import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
const ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'get',
})

ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.definition = {
    methods: ["get","head"],
    url: '/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url = (options?: RouteQueryOptions) => {
    return ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
const ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3bForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3bForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses'
*/
ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3bForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b.form = ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3bForm
/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
const ViewController39cf50c98836c20d29fa0dfb7a7064d0 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'get',
})

ViewController39cf50c98836c20d29fa0dfb7a7064d0.definition = {
    methods: ["get","head"],
    url: '/courses/all',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0.url = (options?: RouteQueryOptions) => {
    return ViewController39cf50c98836c20d29fa0dfb7a7064d0.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
const ViewController39cf50c98836c20d29fa0dfb7a7064d0Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/courses/all'
*/
ViewController39cf50c98836c20d29fa0dfb7a7064d0Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewController39cf50c98836c20d29fa0dfb7a7064d0.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewController39cf50c98836c20d29fa0dfb7a7064d0.form = ViewController39cf50c98836c20d29fa0dfb7a7064d0Form

const ViewController = {
    '/courses': ViewControllerae0d8013bc7dd1aeb7c9b49bac5f9e3b,
    '/courses/all': ViewController39cf50c98836c20d29fa0dfb7a7064d0,
}

export default ViewController