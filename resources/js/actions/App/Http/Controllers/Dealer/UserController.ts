import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
export const create = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/invite_registration/{invite}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
create.url = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { invite: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'invitation_token' in args) {
        args = { invite: args.invitation_token }
    }

    if (Array.isArray(args)) {
        args = {
            invite: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        invite: typeof args.invite === 'object'
        ? args.invite.invitation_token
        : args.invite,
    }

    return create.definition.url
            .replace('{invite}', parsedArgs.invite.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
create.get = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
create.head = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
const createForm = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
createForm.get = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:21
* @route '/invite_registration/{invite}'
*/
createForm.head = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:34
* @route '/employees/dealer/store'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/employees/dealer/store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:34
* @route '/employees/dealer/store'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:34
* @route '/employees/dealer/store'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:34
* @route '/employees/dealer/store'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:34
* @route '/employees/dealer/store'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const UserController = { create, store }

export default UserController