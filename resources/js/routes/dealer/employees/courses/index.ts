import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\UserController::recordResult
* @see app/Http/Controllers/Tenant/UserController.php:363
* @route '/employees/{user}/courses/{course}/result'
*/
export const recordResult = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recordResult.url(args, options),
    method: 'post',
})

recordResult.definition = {
    methods: ["post"],
    url: '/employees/{user}/courses/{course}/result',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\UserController::recordResult
* @see app/Http/Controllers/Tenant/UserController.php:363
* @route '/employees/{user}/courses/{course}/result'
*/
recordResult.url = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            user: args[0],
            course: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.slug
        : args.user,
        course: typeof args.course === 'object'
        ? args.course.id
        : args.course,
    }

    return recordResult.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\UserController::recordResult
* @see app/Http/Controllers/Tenant/UserController.php:363
* @route '/employees/{user}/courses/{course}/result'
*/
recordResult.post = (args: { user: string | { slug: string }, course: number | { id: number } } | [user: string | { slug: string }, course: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recordResult.url(args, options),
    method: 'post',
})

const courses = {
    recordResult: Object.assign(recordResult, recordResult),
}

export default courses