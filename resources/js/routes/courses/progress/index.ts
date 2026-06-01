import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\VideoProgressController::store
* @see app/Http/Controllers/Central/VideoProgressController.php:16
* @route '//dashboard-v2.test/courses/{course}/progress'
*/
export const store = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard-v2.test/courses/{course}/progress',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\VideoProgressController::store
* @see app/Http/Controllers/Central/VideoProgressController.php:16
* @route '//dashboard-v2.test/courses/{course}/progress'
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
* @see \App\Http\Controllers\Central\VideoProgressController::store
* @see app/Http/Controllers/Central/VideoProgressController.php:16
* @route '//dashboard-v2.test/courses/{course}/progress'
*/
store.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\VideoProgressController::store
* @see app/Http/Controllers/Central/VideoProgressController.php:16
* @route '//dashboard-v2.test/courses/{course}/progress'
*/
const storeForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\VideoProgressController::store
* @see app/Http/Controllers/Central/VideoProgressController.php:16
* @route '//dashboard-v2.test/courses/{course}/progress'
*/
storeForm.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

const progress = {
    store: Object.assign(store, store),
}

export default progress