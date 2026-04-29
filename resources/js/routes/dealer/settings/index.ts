import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
import global6b02c0 from './global'
import automatedReports from './automated-reports'
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::global
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
export const global = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: global.url(options),
    method: 'get',
})

global.definition = {
    methods: ["get","head"],
    url: '/global-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::global
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
global.url = (options?: RouteQueryOptions) => {
    return global.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::global
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
global.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: global.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::global
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
global.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: global.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::global
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
const globalForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: global.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::global
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
globalForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: global.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::global
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
globalForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: global.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

global.form = globalForm

const settings = {
    global: Object.assign(global, global6b02c0),
    automatedReports: Object.assign(automatedReports, automatedReports),
}

export default settings