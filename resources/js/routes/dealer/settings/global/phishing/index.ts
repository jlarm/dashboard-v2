import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::update
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:86
* @route '/global-settings/phishing'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/global-settings/phishing',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::update
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:86
* @route '/global-settings/phishing'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::update
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:86
* @route '/global-settings/phishing'
*/
update.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::update
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:86
* @route '/global-settings/phishing'
*/
const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::update
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:86
* @route '/global-settings/phishing'
*/
updateForm.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

const phishing = {
    update: Object.assign(update, update),
}

export default phishing