import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:295
* @route '/employees/{user}/courses'
*/
export const courses = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(args, options),
    method: 'get',
})

courses.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:295
* @route '/employees/{user}/courses'
*/
courses.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return courses.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:295
* @route '/employees/{user}/courses'
*/
courses.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:295
* @route '/employees/{user}/courses'
*/
courses.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: courses.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:295
* @route '/employees/{user}/courses'
*/
const coursesForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:295
* @route '/employees/{user}/courses'
*/
coursesForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::courses
* @see app/Http/Controllers/Tenant/UserController.php:295
* @route '/employees/{user}/courses'
*/
coursesForm.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courses.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

courses.form = coursesForm

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:324
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
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:324
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
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:324
* @route '/employees/{user}/manage-courses'
*/
manageCourses.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: manageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:324
* @route '/employees/{user}/manage-courses'
*/
manageCourses.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: manageCourses.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:324
* @route '/employees/{user}/manage-courses'
*/
const manageCoursesForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: manageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:324
* @route '/employees/{user}/manage-courses'
*/
manageCoursesForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: manageCourses.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::manageCourses
* @see app/Http/Controllers/Tenant/UserController.php:324
* @route '/employees/{user}/manage-courses'
*/
manageCoursesForm.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: manageCourses.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

manageCourses.form = manageCoursesForm

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:352
* @route '/employees/{user}/dot-certificates'
*/
export const dotCertificates = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dotCertificates.url(args, options),
    method: 'get',
})

dotCertificates.definition = {
    methods: ["get","head"],
    url: '/employees/{user}/dot-certificates',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:352
* @route '/employees/{user}/dot-certificates'
*/
dotCertificates.url = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return dotCertificates.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:352
* @route '/employees/{user}/dot-certificates'
*/
dotCertificates.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dotCertificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:352
* @route '/employees/{user}/dot-certificates'
*/
dotCertificates.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dotCertificates.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:352
* @route '/employees/{user}/dot-certificates'
*/
const dotCertificatesForm = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dotCertificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:352
* @route '/employees/{user}/dot-certificates'
*/
dotCertificatesForm.get = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dotCertificates.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\UserController::dotCertificates
* @see app/Http/Controllers/Tenant/UserController.php:352
* @route '/employees/{user}/dot-certificates'
*/
dotCertificatesForm.head = (args: { user: string | { slug: string } } | [user: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dotCertificates.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

dotCertificates.form = dotCertificatesForm

const show = {
    courses: Object.assign(courses, courses),
    manageCourses: Object.assign(manageCourses, manageCourses),
    dotCertificates: Object.assign(dotCertificates, dotCertificates),
}

export default show