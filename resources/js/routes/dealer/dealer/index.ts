import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
import settings69f00b from './settings'
/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
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
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
settings.url = (options?: RouteQueryOptions) => {
    return settings.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
settings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settings.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::settings
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
settings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: settings.url(options),
    method: 'head',
})

const dealer = {
    settings: Object.assign(settings, settings69f00b),
}

export default dealer