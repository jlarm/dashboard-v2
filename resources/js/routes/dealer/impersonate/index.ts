import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see routes/tenant.php:315
* @route '/impersonate/{token}'
*/
export const token = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: token.url(args, options),
    method: 'get',
})

token.definition = {
    methods: ["get","head"],
    url: '/impersonate/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/tenant.php:315
* @route '/impersonate/{token}'
*/
token.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    if (Array.isArray(args)) {
        args = {
            token: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        token: args.token,
    }

    return token.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/tenant.php:315
* @route '/impersonate/{token}'
*/
token.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: token.url(args, options),
    method: 'get',
})

/**
* @see routes/tenant.php:315
* @route '/impersonate/{token}'
*/
token.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: token.url(args, options),
    method: 'head',
})

/**
* @see routes/tenant.php:315
* @route '/impersonate/{token}'
*/
const tokenForm = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: token.url(args, options),
    method: 'get',
})

/**
* @see routes/tenant.php:315
* @route '/impersonate/{token}'
*/
tokenForm.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: token.url(args, options),
    method: 'get',
})

/**
* @see routes/tenant.php:315
* @route '/impersonate/{token}'
*/
tokenForm.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: token.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

token.form = tokenForm

const impersonate = {
    token: Object.assign(token, token),
}

export default impersonate