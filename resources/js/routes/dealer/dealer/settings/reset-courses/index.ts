import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:143
* @route '/settings/reset-courses/{store}'
*/
export const run = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: run.url(args, options),
    method: 'post',
})

run.definition = {
    methods: ["post"],
    url: '/settings/reset-courses/{store}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:143
* @route '/settings/reset-courses/{store}'
*/
run.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return run.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:143
* @route '/settings/reset-courses/{store}'
*/
run.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: run.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:143
* @route '/settings/reset-courses/{store}'
*/
const runForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: run.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:143
* @route '/settings/reset-courses/{store}'
*/
runForm.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: run.url(args, options),
    method: 'post',
})

run.form = runForm

const resetCourses = {
    run: Object.assign(run, run),
}

export default resetCourses