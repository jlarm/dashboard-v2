import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:58
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
* @see app/Http/Controllers/Dealer/UserController.php:58
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
* @see app/Http/Controllers/Dealer/UserController.php:58
* @route '/invite_registration/{invite}'
*/
create.get = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::create
* @see app/Http/Controllers/Dealer/UserController.php:58
* @route '/invite_registration/{invite}'
*/
create.head = (args: { invite: string | number | { invitation_token: string | number } } | [invite: string | number | { invitation_token: string | number } ] | string | number | { invitation_token: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:65
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
* @see app/Http/Controllers/Dealer/UserController.php:65
* @route '/employees/dealer/store'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::store
* @see app/Http/Controllers/Dealer/UserController.php:65
* @route '/employees/dealer/store'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::show
* @see app/Http/Controllers/Dealer/UserController.php:38
* @route '/employees/{user}'
*/
export const show = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/employees/{user}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::show
* @see app/Http/Controllers/Dealer/UserController.php:38
* @route '/employees/{user}'
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
* @see \App\Http\Controllers\Dealer\UserController::show
* @see app/Http/Controllers/Dealer/UserController.php:38
* @route '/employees/{user}'
*/
show.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::show
* @see app/Http/Controllers/Dealer/UserController.php:38
* @route '/employees/{user}'
*/
show.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::showManageCourses
* @see app/Http/Controllers/Dealer/UserController.php:43
* @route '/employees/{user}/manage-courses'
*/
export const showManageCourses = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showManageCourses.url(args, options),
    method: 'get',
})

showManageCourses.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/manage-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::showManageCourses
* @see app/Http/Controllers/Dealer/UserController.php:43
* @route '/employees/{user}/manage-courses'
*/
showManageCourses.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return showManageCourses.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::showManageCourses
* @see app/Http/Controllers/Dealer/UserController.php:43
* @route '/employees/{user}/manage-courses'
*/
showManageCourses.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showManageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::showManageCourses
* @see app/Http/Controllers/Dealer/UserController.php:43
* @route '/employees/{user}/manage-courses'
*/
showManageCourses.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showManageCourses.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::showCertificates
* @see app/Http/Controllers/Dealer/UserController.php:48
* @route '/employees/{user}/certificates'
*/
export const showCertificates = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showCertificates.url(args, options),
    method: 'get',
})

showCertificates.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/certificates',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::showCertificates
* @see app/Http/Controllers/Dealer/UserController.php:48
* @route '/employees/{user}/certificates'
*/
showCertificates.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return showCertificates.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::showCertificates
* @see app/Http/Controllers/Dealer/UserController.php:48
* @route '/employees/{user}/certificates'
*/
showCertificates.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showCertificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::showCertificates
* @see app/Http/Controllers/Dealer/UserController.php:48
* @route '/employees/{user}/certificates'
*/
showCertificates.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showCertificates.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::showVideoProgress
* @see app/Http/Controllers/Dealer/UserController.php:53
* @route '/employees/{user}/video-progress'
*/
export const showVideoProgress = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showVideoProgress.url(args, options),
    method: 'get',
})

showVideoProgress.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/video-progress',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::showVideoProgress
* @see app/Http/Controllers/Dealer/UserController.php:53
* @route '/employees/{user}/video-progress'
*/
showVideoProgress.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return showVideoProgress.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::showVideoProgress
* @see app/Http/Controllers/Dealer/UserController.php:53
* @route '/employees/{user}/video-progress'
*/
showVideoProgress.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showVideoProgress.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::showVideoProgress
* @see app/Http/Controllers/Dealer/UserController.php:53
* @route '/employees/{user}/video-progress'
*/
showVideoProgress.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showVideoProgress.url(args, options),
    method: 'head',
})

const UserController = { create, store, show, showManageCourses, showCertificates, showVideoProgress }

export default UserController