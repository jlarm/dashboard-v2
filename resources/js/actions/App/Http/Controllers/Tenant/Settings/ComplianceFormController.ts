import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::show
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/email/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::show
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::show
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::show
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::show
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
const showForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::show
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
showForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::show
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
showForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

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

const ComplianceFormController = { show, update }

export default ComplianceFormController