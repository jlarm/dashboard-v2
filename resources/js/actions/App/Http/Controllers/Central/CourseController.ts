import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\CourseController::index
* @see app/Http/Controllers/Central/CourseController.php:23
* @route '//dashboard.test/courses'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\CourseController::index
* @see app/Http/Controllers/Central/CourseController.php:23
* @route '//dashboard.test/courses'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\CourseController::index
* @see app/Http/Controllers/Central/CourseController.php:23
* @route '//dashboard.test/courses'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseController::index
* @see app/Http/Controllers/Central/CourseController.php:23
* @route '//dashboard.test/courses'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\CourseController::show
* @see app/Http/Controllers/Central/CourseController.php:32
* @route '//dashboard.test/courses/{course}'
*/
export const show = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/courses/{course}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\CourseController::show
* @see app/Http/Controllers/Central/CourseController.php:32
* @route '//dashboard.test/courses/{course}'
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
* @see \App\Http\Controllers\Central\CourseController::show
* @see app/Http/Controllers/Central/CourseController.php:32
* @route '//dashboard.test/courses/{course}'
*/
show.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseController::show
* @see app/Http/Controllers/Central/CourseController.php:32
* @route '//dashboard.test/courses/{course}'
*/
show.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\CourseController::quiz
* @see app/Http/Controllers/Central/CourseController.php:40
* @route '//dashboard.test/courses/{course}/quiz'
*/
export const quiz = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: quiz.url(args, options),
    method: 'get',
})

quiz.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/courses/{course}/quiz',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\CourseController::quiz
* @see app/Http/Controllers/Central/CourseController.php:40
* @route '//dashboard.test/courses/{course}/quiz'
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
* @see \App\Http\Controllers\Central\CourseController::quiz
* @see app/Http/Controllers/Central/CourseController.php:40
* @route '//dashboard.test/courses/{course}/quiz'
*/
quiz.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: quiz.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\CourseController::quiz
* @see app/Http/Controllers/Central/CourseController.php:40
* @route '//dashboard.test/courses/{course}/quiz'
*/
quiz.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: quiz.url(args, options),
    method: 'head',
})

const CourseController = { index, show, quiz }

export default CourseController