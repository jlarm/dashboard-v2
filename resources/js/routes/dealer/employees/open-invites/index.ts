import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\UserController::resend
* @see app/Http/Controllers/Tenant/UserController.php:163
* @route '/employees/open-invites/resend'
*/
export const resend = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resend.url(options),
    method: 'post',
})

resend.definition = {
    methods: ["post"],
    url: '/employees/open-invites/resend',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::resend
* @see app/Http/Controllers/Tenant/UserController.php:163
* @route '/employees/open-invites/resend'
*/
resend.url = (options?: RouteQueryOptions) => {
    return resend.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::resend
* @see app/Http/Controllers/Tenant/UserController.php:163
* @route '/employees/open-invites/resend'
*/
resend.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resend.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::resendOne
* @see app/Http/Controllers/Tenant/UserController.php:151
* @route '/employees/open-invites/{invite}/resend'
*/
export const resendOne = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resendOne.url(args, options),
    method: 'post',
})

resendOne.definition = {
    methods: ["post"],
    url: '/employees/open-invites/{invite}/resend',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::resendOne
* @see app/Http/Controllers/Tenant/UserController.php:151
* @route '/employees/open-invites/{invite}/resend'
*/
resendOne.url = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return resendOne.definition.url
            .replace('{invite}', parsedArgs.invite.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::resendOne
* @see app/Http/Controllers/Tenant/UserController.php:151
* @route '/employees/open-invites/{invite}/resend'
*/
resendOne.post = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resendOne.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:187
* @route '/employees/open-invites/{invite}'
*/
export const destroy = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/employees/open-invites/{invite}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:187
* @route '/employees/open-invites/{invite}'
*/
destroy.url = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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
* @see \App\Http\Controllers\Tenant\UserController::destroy
* @see app/Http/Controllers/Tenant/UserController.php:187
* @route '/employees/open-invites/{invite}'
*/
destroy.delete = (args: { invite: string | number | { id: string | number } } | [invite: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const openInvites = {
    resend: Object.assign(resend, resend),
    resendOne: Object.assign(resendOne, resendOne),
    destroy: Object.assign(destroy, destroy),
}

export default openInvites