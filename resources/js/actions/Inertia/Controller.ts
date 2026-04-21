import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard.test'
*/
const Controller610a4e9aaa6de76752a548ea04e1d8ee = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controller610a4e9aaa6de76752a548ea04e1d8ee.url(options),
    method: 'get',
})

Controller610a4e9aaa6de76752a548ea04e1d8ee.definition = {
    methods: ["get","head"],
    url: '//dashboard.test',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard.test'
*/
Controller610a4e9aaa6de76752a548ea04e1d8ee.url = (options?: RouteQueryOptions) => {
    return Controller610a4e9aaa6de76752a548ea04e1d8ee.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard.test'
*/
Controller610a4e9aaa6de76752a548ea04e1d8ee.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controller610a4e9aaa6de76752a548ea04e1d8ee.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard.test'
*/
Controller610a4e9aaa6de76752a548ea04e1d8ee.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controller610a4e9aaa6de76752a548ea04e1d8ee.url(options),
    method: 'head',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard.test/settings/appearance'
*/
const Controllerfd1373457de1f8f690273b1ea0dfdcf2 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllerfd1373457de1f8f690273b1ea0dfdcf2.url(options),
    method: 'get',
})

Controllerfd1373457de1f8f690273b1ea0dfdcf2.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/settings/appearance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard.test/settings/appearance'
*/
Controllerfd1373457de1f8f690273b1ea0dfdcf2.url = (options?: RouteQueryOptions) => {
    return Controllerfd1373457de1f8f690273b1ea0dfdcf2.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard.test/settings/appearance'
*/
Controllerfd1373457de1f8f690273b1ea0dfdcf2.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllerfd1373457de1f8f690273b1ea0dfdcf2.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard.test/settings/appearance'
*/
Controllerfd1373457de1f8f690273b1ea0dfdcf2.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controllerfd1373457de1f8f690273b1ea0dfdcf2.url(options),
    method: 'head',
})

const Controller = {
    '//dashboard.test': Controller610a4e9aaa6de76752a548ea04e1d8ee,
    '//dashboard.test/settings/appearance': Controllerfd1373457de1f8f690273b1ea0dfdcf2,
}

export default Controller