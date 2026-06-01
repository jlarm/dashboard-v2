import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard-v2.test/employees'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/employees',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard-v2.test/employees'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard-v2.test/employees'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard-v2.test/employees'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard-v2.test/employees'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard-v2.test/employees'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::index
* @see app/Http/Controllers/Central/UserController.php:24
* @route '//dashboard-v2.test/employees'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard-v2.test/employees/deleted'
*/
export const deleted = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deleted.url(options),
    method: 'get',
})

deleted.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/employees/deleted',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard-v2.test/employees/deleted'
*/
deleted.url = (options?: RouteQueryOptions) => {
    return deleted.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard-v2.test/employees/deleted'
*/
deleted.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deleted.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard-v2.test/employees/deleted'
*/
deleted.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: deleted.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard-v2.test/employees/deleted'
*/
const deletedForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: deleted.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard-v2.test/employees/deleted'
*/
deletedForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: deleted.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::deleted
* @see app/Http/Controllers/Central/UserController.php:41
* @route '//dashboard-v2.test/employees/deleted'
*/
deletedForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: deleted.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

deleted.form = deletedForm

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard-v2.test/employees/{user}'
*/
export const show = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/employees/{user}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard-v2.test/employees/{user}'
*/
show.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { user: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.slug
        : args.user,
    }

    return show.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard-v2.test/employees/{user}'
*/
show.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard-v2.test/employees/{user}'
*/
show.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard-v2.test/employees/{user}'
*/
const showForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard-v2.test/employees/{user}'
*/
showForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\UserController::show
* @see app/Http/Controllers/Central/UserController.php:32
* @route '//dashboard-v2.test/employees/{user}'
*/
showForm.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const UserController = { index, deleted, show }

export default UserController