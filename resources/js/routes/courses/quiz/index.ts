import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\CourseResultController::store
* @see app/Http/Controllers/Central/CourseResultController.php:16
* @route '//dashboard.test/courses/{course}/quiz'
*/
export const store = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/courses/{course}/quiz',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\CourseResultController::store
* @see app/Http/Controllers/Central/CourseResultController.php:16
* @route '//dashboard.test/courses/{course}/quiz'
*/
store.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\CourseResultController::store
* @see app/Http/Controllers/Central/CourseResultController.php:16
* @route '//dashboard.test/courses/{course}/quiz'
*/
store.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

const quiz = {
    store: Object.assign(store, store),
}

export default quiz