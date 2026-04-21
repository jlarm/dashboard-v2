import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\UserController::manageCourses
* @see app/Http/Controllers/Dealer/UserController.php:43
* @route '/employees/{user}/manage-courses'
*/
export const manageCourses = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: manageCourses.url(args, options),
    method: 'get',
})

manageCourses.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/manage-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::manageCourses
* @see app/Http/Controllers/Dealer/UserController.php:43
* @route '/employees/{user}/manage-courses'
*/
manageCourses.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return manageCourses.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::manageCourses
* @see app/Http/Controllers/Dealer/UserController.php:43
* @route '/employees/{user}/manage-courses'
*/
manageCourses.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: manageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::manageCourses
* @see app/Http/Controllers/Dealer/UserController.php:43
* @route '/employees/{user}/manage-courses'
*/
manageCourses.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: manageCourses.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::certificates
* @see app/Http/Controllers/Dealer/UserController.php:48
* @route '/employees/{user}/certificates'
*/
export const certificates = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: certificates.url(args, options),
    method: 'get',
})

certificates.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/certificates',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::certificates
* @see app/Http/Controllers/Dealer/UserController.php:48
* @route '/employees/{user}/certificates'
*/
certificates.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return certificates.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::certificates
* @see app/Http/Controllers/Dealer/UserController.php:48
* @route '/employees/{user}/certificates'
*/
certificates.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: certificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::certificates
* @see app/Http/Controllers/Dealer/UserController.php:48
* @route '/employees/{user}/certificates'
*/
certificates.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: certificates.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::videoProgress
* @see app/Http/Controllers/Dealer/UserController.php:53
* @route '/employees/{user}/video-progress'
*/
export const videoProgress = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: videoProgress.url(args, options),
    method: 'get',
})

videoProgress.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/video-progress',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\UserController::videoProgress
* @see app/Http/Controllers/Dealer/UserController.php:53
* @route '/employees/{user}/video-progress'
*/
videoProgress.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return videoProgress.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\UserController::videoProgress
* @see app/Http/Controllers/Dealer/UserController.php:53
* @route '/employees/{user}/video-progress'
*/
videoProgress.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: videoProgress.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\UserController::videoProgress
* @see app/Http/Controllers/Dealer/UserController.php:53
* @route '/employees/{user}/video-progress'
*/
videoProgress.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: videoProgress.url(args, options),
    method: 'head',
})

const show = {
    manageCourses: Object.assign(manageCourses, manageCourses),
    certificates: Object.assign(certificates, certificates),
    videoProgress: Object.assign(videoProgress, videoProgress),
}

export default show