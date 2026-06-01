import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\InviteController::index
* @see app/Http/Controllers/Central/InviteController.php:26
* @route '//dashboard-v2.test/employees/invites'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/employees/invites',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\InviteController::index
* @see app/Http/Controllers/Central/InviteController.php:26
* @route '//dashboard-v2.test/employees/invites'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\InviteController::index
* @see app/Http/Controllers/Central/InviteController.php:26
* @route '//dashboard-v2.test/employees/invites'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\InviteController::index
* @see app/Http/Controllers/Central/InviteController.php:26
* @route '//dashboard-v2.test/employees/invites'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\InviteController::index
* @see app/Http/Controllers/Central/InviteController.php:26
* @route '//dashboard-v2.test/employees/invites'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\InviteController::index
* @see app/Http/Controllers/Central/InviteController.php:26
* @route '//dashboard-v2.test/employees/invites'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\InviteController::index
* @see app/Http/Controllers/Central/InviteController.php:26
* @route '//dashboard-v2.test/employees/invites'
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
* @see \App\Http\Controllers\Central\InviteController::store
* @see app/Http/Controllers/Central/InviteController.php:33
* @route '//dashboard-v2.test/employees/invites'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard-v2.test/employees/invites',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\InviteController::store
* @see app/Http/Controllers/Central/InviteController.php:33
* @route '//dashboard-v2.test/employees/invites'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\InviteController::store
* @see app/Http/Controllers/Central/InviteController.php:33
* @route '//dashboard-v2.test/employees/invites'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\InviteController::store
* @see app/Http/Controllers/Central/InviteController.php:33
* @route '//dashboard-v2.test/employees/invites'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\InviteController::store
* @see app/Http/Controllers/Central/InviteController.php:33
* @route '//dashboard-v2.test/employees/invites'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Central\InviteController::destroy
* @see app/Http/Controllers/Central/InviteController.php:55
* @route '//dashboard-v2.test/employees/invites/{invite}'
*/
export const destroy = (args: { invite: number | { id: number } } | [invite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard-v2.test/employees/invites/{invite}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\InviteController::destroy
* @see app/Http/Controllers/Central/InviteController.php:55
* @route '//dashboard-v2.test/employees/invites/{invite}'
*/
destroy.url = (args: { invite: number | { id: number } } | [invite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { invite: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { invite: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            invite: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        invite: typeof args.invite === 'object'
        ? args.invite.id
        : args.invite,
    }

    return destroy.definition.url
            .replace('{invite}', parsedArgs.invite.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\InviteController::destroy
* @see app/Http/Controllers/Central/InviteController.php:55
* @route '//dashboard-v2.test/employees/invites/{invite}'
*/
destroy.delete = (args: { invite: number | { id: number } } | [invite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Central\InviteController::destroy
* @see app/Http/Controllers/Central/InviteController.php:55
* @route '//dashboard-v2.test/employees/invites/{invite}'
*/
const destroyForm = (args: { invite: number | { id: number } } | [invite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\InviteController::destroy
* @see app/Http/Controllers/Central/InviteController.php:55
* @route '//dashboard-v2.test/employees/invites/{invite}'
*/
destroyForm.delete = (args: { invite: number | { id: number } } | [invite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const InviteController = { index, store, destroy }

export default InviteController