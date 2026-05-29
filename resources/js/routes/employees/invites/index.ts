import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\InviteController::store
* @see app/Http/Controllers/Central/InviteController.php:33
* @route '//dashboard.test/employees/invites'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/employees/invites',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\InviteController::store
* @see app/Http/Controllers/Central/InviteController.php:33
* @route '//dashboard.test/employees/invites'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\InviteController::store
* @see app/Http/Controllers/Central/InviteController.php:33
* @route '//dashboard.test/employees/invites'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\InviteController::destroy
* @see app/Http/Controllers/Central/InviteController.php:55
* @route '//dashboard.test/employees/invites/{invite}'
*/
export const destroy = (args: { invite: number | { id: number } } | [invite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard.test/employees/invites/{invite}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\InviteController::destroy
* @see app/Http/Controllers/Central/InviteController.php:55
* @route '//dashboard.test/employees/invites/{invite}'
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
* @route '//dashboard.test/employees/invites/{invite}'
*/
destroy.delete = (args: { invite: number | { id: number } } | [invite: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const invites = {
    store: Object.assign(store, store),
    destroy: Object.assign(destroy, destroy),
}

export default invites