import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::update
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:82
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
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:82
* @route '/global-settings/phishing'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::update
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:82
* @route '/global-settings/phishing'
*/
update.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

const phishing = {
    update: Object.assign(update, update),
}

export default phishing