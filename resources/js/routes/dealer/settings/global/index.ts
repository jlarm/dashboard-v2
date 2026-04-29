import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
import resetCoursesBc10d6 from './reset-courses'
import phishingA1fcc4 from './phishing'
import stores from './stores'
import courses from './courses'
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::courseManagement
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
export const courseManagement = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courseManagement.url(options),
    method: 'get',
})

courseManagement.definition = {
    methods: ["get","head"],
    url: '/global-settings/course-management',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::courseManagement
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
courseManagement.url = (options?: RouteQueryOptions) => {
    return courseManagement.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::courseManagement
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
courseManagement.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courseManagement.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::courseManagement
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
courseManagement.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: courseManagement.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
export const resetCourses = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: resetCourses.url(options),
    method: 'get',
})

resetCourses.definition = {
    methods: ["get","head"],
    url: '/global-settings/reset-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
resetCourses.url = (options?: RouteQueryOptions) => {
    return resetCourses.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
resetCourses.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: resetCourses.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
resetCourses.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: resetCourses.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::phishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
export const phishing = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: phishing.url(options),
    method: 'get',
})

phishing.definition = {
    methods: ["get","head"],
    url: '/global-settings/phishing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::phishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
phishing.url = (options?: RouteQueryOptions) => {
    return phishing.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::phishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
phishing.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: phishing.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::phishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
phishing.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: phishing.url(options),
    method: 'head',
})

const global = {
    courseManagement: Object.assign(courseManagement, courseManagement),
    resetCourses: Object.assign(resetCourses, resetCoursesBc10d6),
    phishing: Object.assign(phishing, phishingA1fcc4),
    stores: Object.assign(stores, stores),
    courses: Object.assign(courses, courses),
}

export default global