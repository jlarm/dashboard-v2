import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
import settings69f00b from './settings'
/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:38
* @route '/settings'
*/
export const settings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

settings.definition = {
    methods: ["get","head"],
    url: '/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:38
* @route '/settings'
*/
settings.url = (options?: RouteQueryOptions) => {
    return settings.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:38
* @route '/settings'
*/
settings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:38
* @route '/settings'
*/
settings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: settings.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:38
* @route '/settings'
*/
const settingsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:38
* @route '/settings'
*/
settingsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:38
* @route '/settings'
*/
settingsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: settings.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

settings.form = settingsForm

const dealer = {
    settings: Object.assign(settings, settings69f00b),
}

export default dealer