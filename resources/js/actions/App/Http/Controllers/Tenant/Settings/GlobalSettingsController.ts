import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
const index84eaef77ed484e45d931ed7337b74dfe = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'get',
})

index84eaef77ed484e45d931ed7337b74dfe.definition = {
    methods: ["get","head"],
    url: '/global-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
index84eaef77ed484e45d931ed7337b74dfe.url = (options?: RouteQueryOptions) => {
    return index84eaef77ed484e45d931ed7337b74dfe.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
index84eaef77ed484e45d931ed7337b74dfe.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
index84eaef77ed484e45d931ed7337b74dfe.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
const index84eaef77ed484e45d931ed7337b74dfeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
index84eaef77ed484e45d931ed7337b74dfeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings'
*/
index84eaef77ed484e45d931ed7337b74dfeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index84eaef77ed484e45d931ed7337b74dfe.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index84eaef77ed484e45d931ed7337b74dfe.form = index84eaef77ed484e45d931ed7337b74dfeForm
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
const indexce0eb901513cf042a12cae43acdd20b9 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'get',
})

indexce0eb901513cf042a12cae43acdd20b9.definition = {
    methods: ["get","head"],
    url: '/global-settings/course-management',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
indexce0eb901513cf042a12cae43acdd20b9.url = (options?: RouteQueryOptions) => {
    return indexce0eb901513cf042a12cae43acdd20b9.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
indexce0eb901513cf042a12cae43acdd20b9.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
indexce0eb901513cf042a12cae43acdd20b9.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: indexce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
const indexce0eb901513cf042a12cae43acdd20b9Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
indexce0eb901513cf042a12cae43acdd20b9Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/course-management'
*/
indexce0eb901513cf042a12cae43acdd20b9Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexce0eb901513cf042a12cae43acdd20b9.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

indexce0eb901513cf042a12cae43acdd20b9.form = indexce0eb901513cf042a12cae43acdd20b9Form
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
const index28cdf476162496027c9b301bf30468cb = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index28cdf476162496027c9b301bf30468cb.url(options),
    method: 'get',
})

index28cdf476162496027c9b301bf30468cb.definition = {
    methods: ["get","head"],
    url: '/global-settings/reset-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
index28cdf476162496027c9b301bf30468cb.url = (options?: RouteQueryOptions) => {
    return index28cdf476162496027c9b301bf30468cb.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
index28cdf476162496027c9b301bf30468cb.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index28cdf476162496027c9b301bf30468cb.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
index28cdf476162496027c9b301bf30468cb.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index28cdf476162496027c9b301bf30468cb.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
const index28cdf476162496027c9b301bf30468cbForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index28cdf476162496027c9b301bf30468cb.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
index28cdf476162496027c9b301bf30468cbForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index28cdf476162496027c9b301bf30468cb.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/reset-courses'
*/
index28cdf476162496027c9b301bf30468cbForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index28cdf476162496027c9b301bf30468cb.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index28cdf476162496027c9b301bf30468cb.form = index28cdf476162496027c9b301bf30468cbForm
/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
const indexfdc1627b9e2da467884f33613f26ccc3 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'get',
})

indexfdc1627b9e2da467884f33613f26ccc3.definition = {
    methods: ["get","head"],
    url: '/global-settings/phishing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
indexfdc1627b9e2da467884f33613f26ccc3.url = (options?: RouteQueryOptions) => {
    return indexfdc1627b9e2da467884f33613f26ccc3.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
indexfdc1627b9e2da467884f33613f26ccc3.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
indexfdc1627b9e2da467884f33613f26ccc3.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: indexfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
const indexfdc1627b9e2da467884f33613f26ccc3Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
indexfdc1627b9e2da467884f33613f26ccc3Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:47
* @route '/global-settings/phishing'
*/
indexfdc1627b9e2da467884f33613f26ccc3Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexfdc1627b9e2da467884f33613f26ccc3.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

indexfdc1627b9e2da467884f33613f26ccc3.form = indexfdc1627b9e2da467884f33613f26ccc3Form

export const index = {
    '/global-settings': index84eaef77ed484e45d931ed7337b74dfe,
    '/global-settings/course-management': indexce0eb901513cf042a12cae43acdd20b9,
    '/global-settings/reset-courses': index28cdf476162496027c9b301bf30468cb,
    '/global-settings/phishing': indexfdc1627b9e2da467884f33613f26ccc3,
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::updatePhishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:82
* @route '/global-settings/phishing'
*/
export const updatePhishing = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updatePhishing.url(options),
    method: 'patch',
})

updatePhishing.definition = {
    methods: ["patch"],
    url: '/global-settings/phishing',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::updatePhishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:82
* @route '/global-settings/phishing'
*/
updatePhishing.url = (options?: RouteQueryOptions) => {
    return updatePhishing.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::updatePhishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:82
* @route '/global-settings/phishing'
*/
updatePhishing.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updatePhishing.url(options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::updatePhishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:82
* @route '/global-settings/phishing'
*/
const updatePhishingForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updatePhishing.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::updatePhishing
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:82
* @route '/global-settings/phishing'
*/
updatePhishingForm.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updatePhishing.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updatePhishing.form = updatePhishingForm

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreNotifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:89
* @route '/global-settings/stores/{store}/notifications'
*/
export const toggleStoreNotifications = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleStoreNotifications.url(args, options),
    method: 'post',
})

toggleStoreNotifications.definition = {
    methods: ["post"],
    url: '/global-settings/stores/{store}/notifications',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreNotifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:89
* @route '/global-settings/stores/{store}/notifications'
*/
toggleStoreNotifications.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return toggleStoreNotifications.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreNotifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:89
* @route '/global-settings/stores/{store}/notifications'
*/
toggleStoreNotifications.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleStoreNotifications.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreNotifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:89
* @route '/global-settings/stores/{store}/notifications'
*/
const toggleStoreNotificationsForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleStoreNotifications.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreNotifications
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:89
* @route '/global-settings/stores/{store}/notifications'
*/
toggleStoreNotificationsForm.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleStoreNotifications.url(args, options),
    method: 'post',
})

toggleStoreNotifications.form = toggleStoreNotificationsForm

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreRemediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:98
* @route '/global-settings/stores/{store}/remediations'
*/
export const toggleStoreRemediations = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleStoreRemediations.url(args, options),
    method: 'post',
})

toggleStoreRemediations.definition = {
    methods: ["post"],
    url: '/global-settings/stores/{store}/remediations',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreRemediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:98
* @route '/global-settings/stores/{store}/remediations'
*/
toggleStoreRemediations.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return toggleStoreRemediations.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreRemediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:98
* @route '/global-settings/stores/{store}/remediations'
*/
toggleStoreRemediations.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: toggleStoreRemediations.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreRemediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:98
* @route '/global-settings/stores/{store}/remediations'
*/
const toggleStoreRemediationsForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleStoreRemediations.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleStoreRemediations
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:98
* @route '/global-settings/stores/{store}/remediations'
*/
toggleStoreRemediationsForm.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleStoreRemediations.url(args, options),
    method: 'post',
})

toggleStoreRemediations.form = toggleStoreRemediationsForm

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleOptionalCourse
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:107
* @route '/global-settings/courses/{course}/optional'
*/
export const toggleOptionalCourse = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: toggleOptionalCourse.url(args, options),
    method: 'patch',
})

toggleOptionalCourse.definition = {
    methods: ["patch"],
    url: '/global-settings/courses/{course}/optional',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleOptionalCourse
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:107
* @route '/global-settings/courses/{course}/optional'
*/
toggleOptionalCourse.url = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { course: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            course: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        course: typeof args.course === 'object'
        ? args.course.id
        : args.course,
    }

    return toggleOptionalCourse.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleOptionalCourse
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:107
* @route '/global-settings/courses/{course}/optional'
*/
toggleOptionalCourse.patch = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: toggleOptionalCourse.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleOptionalCourse
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:107
* @route '/global-settings/courses/{course}/optional'
*/
const toggleOptionalCourseForm = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleOptionalCourse.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::toggleOptionalCourse
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:107
* @route '/global-settings/courses/{course}/optional'
*/
toggleOptionalCourseForm.patch = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: toggleOptionalCourse.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

toggleOptionalCourse.form = toggleOptionalCourseForm

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:116
* @route '/global-settings/reset-courses'
*/
export const resetCourses = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resetCourses.url(options),
    method: 'post',
})

resetCourses.definition = {
    methods: ["post"],
    url: '/global-settings/reset-courses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:116
* @route '/global-settings/reset-courses'
*/
resetCourses.url = (options?: RouteQueryOptions) => {
    return resetCourses.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:116
* @route '/global-settings/reset-courses'
*/
resetCourses.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resetCourses.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:116
* @route '/global-settings/reset-courses'
*/
const resetCoursesForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: resetCourses.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\GlobalSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/GlobalSettingsController.php:116
* @route '/global-settings/reset-courses'
*/
resetCoursesForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: resetCourses.url(options),
    method: 'post',
})

resetCourses.form = resetCoursesForm

const GlobalSettingsController = { index, updatePhishing, toggleStoreNotifications, toggleStoreRemediations, toggleOptionalCourse, resetCourses }

export default GlobalSettingsController