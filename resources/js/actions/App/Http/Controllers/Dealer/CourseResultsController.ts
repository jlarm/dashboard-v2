import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\CourseResultsController::store
* @see app/Http/Controllers/Dealer/CourseResultsController.php:30
* @route '/courses/{course}'
*/
export const store = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/courses/{course}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\CourseResultsController::store
* @see app/Http/Controllers/Dealer/CourseResultsController.php:30
* @route '/courses/{course}'
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
* @see \App\Http\Controllers\Dealer\CourseResultsController::store
* @see app/Http/Controllers/Dealer/CourseResultsController.php:30
* @route '/courses/{course}'
*/
store.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\CourseResultsController::store
* @see app/Http/Controllers/Dealer/CourseResultsController.php:30
* @route '/courses/{course}'
*/
const storeForm = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\CourseResultsController::store
* @see app/Http/Controllers/Dealer/CourseResultsController.php:30
* @route '/courses/{course}'
*/
storeForm.post = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

const CourseResultsController = { store }

export default CourseResultsControllerl(args, options),
    method: 'post',
})

store.form = storeForm

const CourseResultsController = { store }

export default CourseResultsController