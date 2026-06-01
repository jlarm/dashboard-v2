import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::update
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:45
* @route '/email/settings'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/email/settings',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::update
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:45
* @route '/email/settings'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::update
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:45
* @route '/email/settings'
*/
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::update
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:45
* @route '/email/settings'
*/
const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::update
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:45
* @route '/email/settings'
*/
updateForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(options),
    method: 'post',
})

update.form = updateForm
