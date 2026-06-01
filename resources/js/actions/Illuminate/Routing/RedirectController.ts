import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults, validateParameters } from './../../../wayfinder'
/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
const RedirectController0f90409069c7ddcbfa4db7398cde9d76 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'get',
})

RedirectController0f90409069c7ddcbfa4db7398cde9d76.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '//dashboard-v2.test/settings',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76.url = (options?: RouteQueryOptions) => {
    return RedirectController0f90409069c7ddcbfa4db7398cde9d76.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'put',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'patch',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'delete',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76.options = (options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'options',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
const RedirectController0f90409069c7ddcbfa4db7398cde9d76Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76Form.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76Form.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76Form.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '//dashboard-v2.test/settings'
*/
RedirectController0f90409069c7ddcbfa4db7398cde9d76Form.options = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController0f90409069c7ddcbfa4db7398cde9d76.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'OPTIONS',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RedirectController0f90409069c7ddcbfa4db7398cde9d76.form = RedirectController0f90409069c7ddcbfa4db7398cde9d76Form
/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
const RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'get',
})

RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '/stores/{path?}',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { path: args }
    }

    if (Array.isArray(args)) {
        args = {
            path: args[0],
        }
    }

    args = applyUrlDefaults(args)

    validateParameters(args, [
        "path",
    ])

    const parsedArgs = {
        path: args?.path,
    }

    return RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.definition.url
            .replace('{path?}', parsedArgs.path?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.get = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.head = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.post = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.put = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'put',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.patch = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'patch',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.delete = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'delete',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.options = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'options',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
const RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm.get = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm.head = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm.post = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm.put = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm.patch = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm.delete = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/stores/{path?}'
*/
RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm.options = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'OPTIONS',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca.form = RedirectController5d40208b2ac3ad3e0fd02f29aabcb6caForm

/**
* Multiple routes resolve to \Illuminate\Routing\RedirectController::RedirectController, so this export is a
* dictionary keyed by URI rather than a callable. Call a specific route with `RedirectController['<uri>'](...)`,
* or import the route by name from your generated `routes/` directory.
*/
const RedirectController = {
    '//dashboard-v2.test/settings': RedirectController0f90409069c7ddcbfa4db7398cde9d76,
    '/stores/{path?}': RedirectController5d40208b2ac3ad3e0fd02f29aabcb6ca,
}

export default RedirectController