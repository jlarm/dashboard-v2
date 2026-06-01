import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test'
*/
const Controller82fbb368f655aaded4cad647dc79d063 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controller82fbb368f655aaded4cad647dc79d063.url(options),
    method: 'get',
})

Controller82fbb368f655aaded4cad647dc79d063.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test'
*/
Controller82fbb368f655aaded4cad647dc79d063.url = (options?: RouteQueryOptions) => {
    return Controller82fbb368f655aaded4cad647dc79d063.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test'
*/
Controller82fbb368f655aaded4cad647dc79d063.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controller82fbb368f655aaded4cad647dc79d063.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test'
*/
Controller82fbb368f655aaded4cad647dc79d063.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controller82fbb368f655aaded4cad647dc79d063.url(options),
    method: 'head',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test'
*/
const Controller82fbb368f655aaded4cad647dc79d063Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controller82fbb368f655aaded4cad647dc79d063.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test'
*/
Controller82fbb368f655aaded4cad647dc79d063Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controller82fbb368f655aaded4cad647dc79d063.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test'
*/
Controller82fbb368f655aaded4cad647dc79d063Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controller82fbb368f655aaded4cad647dc79d063.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Controller82fbb368f655aaded4cad647dc79d063.form = Controller82fbb368f655aaded4cad647dc79d063Form
/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test/settings/appearance'
*/
const Controllera242d9417dd9165f12b8cb943fe376c6 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllera242d9417dd9165f12b8cb943fe376c6.url(options),
    method: 'get',
})

Controllera242d9417dd9165f12b8cb943fe376c6.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/settings/appearance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test/settings/appearance'
*/
Controllera242d9417dd9165f12b8cb943fe376c6.url = (options?: RouteQueryOptions) => {
    return Controllera242d9417dd9165f12b8cb943fe376c6.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test/settings/appearance'
*/
Controllera242d9417dd9165f12b8cb943fe376c6.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllera242d9417dd9165f12b8cb943fe376c6.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test/settings/appearance'
*/
Controllera242d9417dd9165f12b8cb943fe376c6.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controllera242d9417dd9165f12b8cb943fe376c6.url(options),
    method: 'head',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test/settings/appearance'
*/
const Controllera242d9417dd9165f12b8cb943fe376c6Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controllera242d9417dd9165f12b8cb943fe376c6.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test/settings/appearance'
*/
Controllera242d9417dd9165f12b8cb943fe376c6Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controllera242d9417dd9165f12b8cb943fe376c6.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '//dashboard-v2.test/settings/appearance'
*/
Controllera242d9417dd9165f12b8cb943fe376c6Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controllera242d9417dd9165f12b8cb943fe376c6.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Controllera242d9417dd9165f12b8cb943fe376c6.form = Controllera242d9417dd9165f12b8cb943fe376c6Form
/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
const Controller980bb49ee7ae63891f1d891d2fbcf1c9 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controller980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
    method: 'get',
})

Controller980bb49ee7ae63891f1d891d2fbcf1c9.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
Controller980bb49ee7ae63891f1d891d2fbcf1c9.url = (options?: RouteQueryOptions) => {
    return Controller980bb49ee7ae63891f1d891d2fbcf1c9.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
Controller980bb49ee7ae63891f1d891d2fbcf1c9.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controller980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
Controller980bb49ee7ae63891f1d891d2fbcf1c9.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controller980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
    method: 'head',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
const Controller980bb49ee7ae63891f1d891d2fbcf1c9Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controller980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
Controller980bb49ee7ae63891f1d891d2fbcf1c9Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controller980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/'
*/
Controller980bb49ee7ae63891f1d891d2fbcf1c9Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controller980bb49ee7ae63891f1d891d2fbcf1c9.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Controller980bb49ee7ae63891f1d891d2fbcf1c9.form = Controller980bb49ee7ae63891f1d891d2fbcf1c9Form
/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/appearance'
*/
const Controllerc7603d42d6a6e34439fbe956554a27e2 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllerc7603d42d6a6e34439fbe956554a27e2.url(options),
    method: 'get',
})

Controllerc7603d42d6a6e34439fbe956554a27e2.definition = {
    methods: ["get","head"],
    url: '/appearance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/appearance'
*/
Controllerc7603d42d6a6e34439fbe956554a27e2.url = (options?: RouteQueryOptions) => {
    return Controllerc7603d42d6a6e34439fbe956554a27e2.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/appearance'
*/
Controllerc7603d42d6a6e34439fbe956554a27e2.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllerc7603d42d6a6e34439fbe956554a27e2.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/appearance'
*/
Controllerc7603d42d6a6e34439fbe956554a27e2.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controllerc7603d42d6a6e34439fbe956554a27e2.url(options),
    method: 'head',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/appearance'
*/
const Controllerc7603d42d6a6e34439fbe956554a27e2Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controllerc7603d42d6a6e34439fbe956554a27e2.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/appearance'
*/
Controllerc7603d42d6a6e34439fbe956554a27e2Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controllerc7603d42d6a6e34439fbe956554a27e2.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/appearance'
*/
Controllerc7603d42d6a6e34439fbe956554a27e2Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Controllerc7603d42d6a6e34439fbe956554a27e2.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Controllerc7603d42d6a6e34439fbe956554a27e2.form = Controllerc7603d42d6a6e34439fbe956554a27e2Form

/**
* Multiple routes resolve to \Inertia\Controller::Controller, so this export is a
* dictionary keyed by URI rather than a callable. Call a specific route with `Controller['<uri>'](...)`,
* or import the route by name from your generated `routes/` directory.
*/
const Controller = {
    '//dashboard-v2.test': Controller82fbb368f655aaded4cad647dc79d063,
    '//dashboard-v2.test/settings/appearance': Controllera242d9417dd9165f12b8cb943fe376c6,
    '/': Controller980bb49ee7ae63891f1d891d2fbcf1c9,
    '/appearance': Controllerc7603d42d6a6e34439fbe956554a27e2,
}

export default Controller