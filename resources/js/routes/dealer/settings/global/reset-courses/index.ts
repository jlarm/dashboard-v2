import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:108
* @route '/global-settings/reset-courses'
*/
export const run = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: run.url(options),
    method: 'post',
})

run.definition = {
    methods: ["post"],
    url: '/global-settings/reset-courses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:108
* @route '/global-settings/reset-courses'
*/
run.url = (options?: RouteQueryOptions) => {
    return run.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:108
* @route '/global-settings/reset-courses'
*/
run.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: run.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:108
* @route '/global-settings/reset-courses'
*/
const runForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: run.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::run
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:108
* @route '/global-settings/reset-courses'
*/
runForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: run.url(options),
    method: 'post',
})

run.form = runForm

const resetCourses = {
    run: Object.assign(run, run),
}

export default resetCourses