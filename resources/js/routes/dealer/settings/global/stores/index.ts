import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::notifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:93
* @route '/global-settings/stores/{store}/notifications'
*/
export const notifications = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: notifications.url(args, options),
    method: 'post',
})

notifications.definition = {
    methods: ["post"],
    url: '/global-settings/stores/{store}/notifications',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::notifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:93
* @route '/global-settings/stores/{store}/notifications'
*/
notifications.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return notifications.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::notifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:93
* @route '/global-settings/stores/{store}/notifications'
*/
notifications.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: notifications.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::notifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:93
* @route '/global-settings/stores/{store}/notifications'
*/
const notificationsForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: notifications.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::notifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:93
* @route '/global-settings/stores/{store}/notifications'
*/
notificationsForm.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: notifications.url(args, options),
    method: 'post',
})

notifications.form = notificationsForm

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::remediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:102
* @route '/global-settings/stores/{store}/remediations'
*/
export const remediations = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: remediations.url(args, options),
    method: 'post',
})

remediations.definition = {
    methods: ["post"],
    url: '/global-settings/stores/{store}/remediations',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::remediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:102
* @route '/global-settings/stores/{store}/remediations'
*/
remediations.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return remediations.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::remediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:102
* @route '/global-settings/stores/{store}/remediations'
*/
remediations.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: remediations.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::remediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:102
* @route '/global-settings/stores/{store}/remediations'
*/
const remediationsForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: remediations.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::remediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:102
* @route '/global-settings/stores/{store}/remediations'
*/
remediationsForm.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: remediations.url(args, options),
    method: 'post',
})

remediations.form = remediationsForm

const stores = {
    notifications: Object.assign(notifications, notifications),
    remediations: Object.assign(remediations, remediations),
}

export default stores