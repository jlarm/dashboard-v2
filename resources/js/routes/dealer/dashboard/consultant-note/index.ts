import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\DashboardController::update
* @see app/Http/Controllers/Tenant/DashboardController.php:160
* @route '/dashboard/consultant-note'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/dashboard/consultant-note',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\DashboardController::update
* @see app/Http/Controllers/Tenant/DashboardController.php:160
* @route '/dashboard/consultant-note'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DashboardController::update
* @see app/Http/Controllers/Tenant/DashboardController.php:160
* @route '/dashboard/consultant-note'
*/
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::update
* @see app/Http/Controllers/Tenant/DashboardController.php:160
* @route '/dashboard/consultant-note'
*/
const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\DashboardController::update
* @see app/Http/Controllers/Tenant/DashboardController.php:160
* @route '/dashboard/consultant-note'
*/
updateForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(options),
    method: 'post',
})

update.form = updateForm

const consultantNote = {
    update: Object.assign(update, update),
}

export default consultantNote