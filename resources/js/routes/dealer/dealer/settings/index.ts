import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
import general from './general'
import resetCoursesBc10d6 from './reset-courses'
/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::form
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
export const form = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

form.definition = {
    methods: ["get","head"],
    url: '/email/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::form
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
form.url = (options?: RouteQueryOptions) => {
    return form.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::form
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
form.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ComplianceFormController::form
* @see app/Http/Controllers/Tenant/Settings/ComplianceFormController.php:26
* @route '/email/settings'
*/
form.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: form.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::managers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
export const managers = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: managers.url(options),
    method: 'get',
})

managers.definition = {
    methods: ["get","head"],
    url: '/settings/managers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::managers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
managers.url = (options?: RouteQueryOptions) => {
    return managers.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::managers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
managers.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: managers.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::managers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
managers.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: managers.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::compliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
export const compliance = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: compliance.url(options),
    method: 'get',
})

compliance.definition = {
    methods: ["get","head"],
    url: '/settings/compliance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::compliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
compliance.url = (options?: RouteQueryOptions) => {
    return compliance.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::compliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
compliance.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: compliance.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::compliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
compliance.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: compliance.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
export const resetCourses = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: resetCourses.url(options),
    method: 'get',
})

resetCourses.definition = {
    methods: ["get","head"],
    url: '/settings/reset-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
resetCourses.url = (options?: RouteQueryOptions) => {
    return resetCourses.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
resetCourses.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: resetCourses.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
resetCourses.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: resetCourses.url(options),
    method: 'head',
})

const settings = {
    general: Object.assign(general, general),
    managers: Object.assign(managers, managers),
    compliance: Object.assign(compliance, compliance),
    resetCourses: Object.assign(resetCourses, resetCoursesBc10d6),
}

export default settings