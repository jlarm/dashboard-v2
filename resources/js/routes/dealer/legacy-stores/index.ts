import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults, validateParameters } from './../../../wayfinder'
/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
export const redirect = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: redirect.url(args, options),
    method: 'get',
})

redirect.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '/stores/{path?}',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
redirect.url = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return redirect.definition.url
            .replace('{path?}', parsedArgs.path?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
redirect.get = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: redirect.url(args, options),
    method: 'get',
})

/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
redirect.head = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: redirect.url(args, options),
    method: 'head',
})

/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
redirect.post = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: redirect.url(args, options),
    method: 'post',
})

/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
redirect.put = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: redirect.url(args, options),
    method: 'put',
})

/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
redirect.patch = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: redirect.url(args, options),
    method: 'patch',
})

/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
redirect.delete = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: redirect.url(args, options),
    method: 'delete',
})

/**
* @see routes/tenant.php:76
* @route '/stores/{path?}'
*/
redirect.options = (args?: { path?: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: redirect.url(args, options),
    method: 'options',
})

const legacyStores = {
    redirect: Object.assign(redirect, redirect),
}

export default legacyStores