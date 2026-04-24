import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
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
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
courseManagement.url = (options?: RouteQueryOptions) => {
    return courseManagement.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
courseManagement.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courseManagement.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
courseManagement.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: courseManagement.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
const courseManagementForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courseManagement.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
courseManagementForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courseManagement.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
courseManagementForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: courseManagement.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

courseManagement.form = courseManagementForm

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
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
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
resetCourses.url = (options?: RouteQueryOptions) => {
    return resetCourses.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
resetCourses.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: resetCourses.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
resetCourses.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: resetCourses.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
const resetCoursesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: resetCourses.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
resetCoursesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: resetCourses.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
resetCoursesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: resetCourses.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

resetCourses.form = resetCoursesForm

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
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
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
phishing.url = (options?: RouteQueryOptions) => {
    return phishing.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
phishing.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: phishing.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
phishing.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: phishing.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
const phishingForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: phishing.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
phishingForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: phishing.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
phishingForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: phishing.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

phishing.form = phishingForm

const global = {
    courseManagement: Object.assign(courseManagement, courseManagement),
    resetCourses: Object.assign(resetCourses, resetCourses),
    phishing: Object.assign(phishing, phishing),
}

export default global