import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
import dotCertificate from './dot-certificate'
import results from './results'
/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:29
* @route '/courses'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:29
* @route '/courses'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:29
* @route '/courses'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::index
* @see app/Http/Controllers/Tenant/CourseController.php:29
* @route '/courses'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:44
* @route '/courses/all'
*/
export const all = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: all.url(options),
    method: 'get',
})

all.definition = {
    methods: ["get","head"],
    url: '/courses/all',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:44
* @route '/courses/all'
*/
all.url = (options?: RouteQueryOptions) => {
    return all.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:44
* @route '/courses/all'
*/
all.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: all.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::all
* @see app/Http/Controllers/Tenant/CourseController.php:44
* @route '/courses/all'
*/
all.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: all.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:53
* @route '/courses/{course}'
*/
export const show = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/courses/{course}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:53
* @route '/courses/{course}'
*/
show.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { course: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.slug
        : args.course,
    }

    return show.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:53
* @route '/courses/{course}'
*/
show.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::show
* @see app/Http/Controllers/Tenant/CourseController.php:53
* @route '/courses/{course}'
*/
show.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:69
* @route '/courses/{course}/quiz'
*/
export const quiz = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: quiz.url(args, options),
    method: 'get',
})

quiz.definition = {
    methods: ["get","head"],
    url: '/courses/{course}/quiz',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:69
* @route '/courses/{course}/quiz'
*/
quiz.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { course: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.slug
        : args.course,
    }

    return quiz.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:69
* @route '/courses/{course}/quiz'
*/
quiz.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: quiz.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::quiz
* @see app/Http/Controllers/Tenant/CourseController.php:69
* @route '/courses/{course}/quiz'
*/
quiz.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: quiz.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CourseController::videoComplete
* @see app/Http/Controllers/Tenant/CourseController.php:112
* @route '/courses/{course}/video-complete'
*/
export const videoComplete = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: videoComplete.url(args, options),
    method: 'post',
})

videoComplete.definition = {
    methods: ["post"],
    url: '/courses/{course}/video-complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\CourseController::videoComplete
* @see app/Http/Controllers/Tenant/CourseController.php:112
* @route '/courses/{course}/video-complete'
*/
videoComplete.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { course: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.slug
        : args.course,
    }

    return videoComplete.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CourseController::videoComplete
* @see app/Http/Controllers/Tenant/CourseController.php:112
* @route '/courses/{course}/video-complete'
*/
videoComplete.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: videoComplete.url(args, options),
    method: 'post',
})

const courses = {
    index: Object.assign(index, index),
    all: Object.assign(all, all),
    dotCertificate: Object.assign(dotCertificate, dotCertificate),
    show: Object.assign(show, show),
    quiz: Object.assign(quiz, quiz),
    results: Object.assign(results, results),
    videoComplete: Object.assign(videoComplete, videoComplete),
}

export default courses