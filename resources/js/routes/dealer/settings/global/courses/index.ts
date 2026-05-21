import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::optional
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:96
* @route '/global-settings/courses/{course}/optional'
*/
export const optional = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: optional.url(args, options),
    method: 'patch',
})

optional.definition = {
    methods: ["patch"],
    url: '/global-settings/courses/{course}/optional',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::optional
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:96
* @route '/global-settings/courses/{course}/optional'
*/
optional.url = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { course: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.id
        : args.course,
    }

    return optional.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::optional
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:96
* @route '/global-settings/courses/{course}/optional'
*/
optional.patch = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: optional.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::optional
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:96
* @route '/global-settings/courses/{course}/optional'
*/
const optionalForm = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: optional.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::optional
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:96
* @route '/global-settings/courses/{course}/optional'
*/
optionalForm.patch = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: optional.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

optional.form = optionalForm

const courses = {
    optional: Object.assign(optional, optional),
}

export default courses