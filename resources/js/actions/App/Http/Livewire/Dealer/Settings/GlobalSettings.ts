import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
const GlobalSettings84eaef77ed484e45d931ed7337b74dfe = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlobalSettings84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'get',
})

GlobalSettings84eaef77ed484e45d931ed7337b74dfe.definition = {
    methods: ["get","head"],
    url: '/global-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
GlobalSettings84eaef77ed484e45d931ed7337b74dfe.url = (options?: RouteQueryOptions) => {
    return GlobalSettings84eaef77ed484e45d931ed7337b74dfe.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
GlobalSettings84eaef77ed484e45d931ed7337b74dfe.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlobalSettings84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
GlobalSettings84eaef77ed484e45d931ed7337b74dfe.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: GlobalSettings84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
const GlobalSettings84eaef77ed484e45d931ed7337b74dfeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettings84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
GlobalSettings84eaef77ed484e45d931ed7337b74dfeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettings84eaef77ed484e45d931ed7337b74dfe.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
GlobalSettings84eaef77ed484e45d931ed7337b74dfeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettings84eaef77ed484e45d931ed7337b74dfe.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

GlobalSettings84eaef77ed484e45d931ed7337b74dfe.form = GlobalSettings84eaef77ed484e45d931ed7337b74dfeForm
/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
const GlobalSettingsce0eb901513cf042a12cae43acdd20b9 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlobalSettingsce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'get',
})

GlobalSettingsce0eb901513cf042a12cae43acdd20b9.definition = {
    methods: ["get","head"],
    url: '/global-settings/course-management',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
GlobalSettingsce0eb901513cf042a12cae43acdd20b9.url = (options?: RouteQueryOptions) => {
    return GlobalSettingsce0eb901513cf042a12cae43acdd20b9.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
GlobalSettingsce0eb901513cf042a12cae43acdd20b9.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlobalSettingsce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
GlobalSettingsce0eb901513cf042a12cae43acdd20b9.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: GlobalSettingsce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
const GlobalSettingsce0eb901513cf042a12cae43acdd20b9Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettingsce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
GlobalSettingsce0eb901513cf042a12cae43acdd20b9Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettingsce0eb901513cf042a12cae43acdd20b9.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/course-management'
*/
GlobalSettingsce0eb901513cf042a12cae43acdd20b9Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettingsce0eb901513cf042a12cae43acdd20b9.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

GlobalSettingsce0eb901513cf042a12cae43acdd20b9.form = GlobalSettingsce0eb901513cf042a12cae43acdd20b9Form
/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
const GlobalSettings28cdf476162496027c9b301bf30468cb = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlobalSettings28cdf476162496027c9b301bf30468cb.url(options),
    method: 'get',
})

GlobalSettings28cdf476162496027c9b301bf30468cb.definition = {
    methods: ["get","head"],
    url: '/global-settings/reset-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
GlobalSettings28cdf476162496027c9b301bf30468cb.url = (options?: RouteQueryOptions) => {
    return GlobalSettings28cdf476162496027c9b301bf30468cb.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
GlobalSettings28cdf476162496027c9b301bf30468cb.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlobalSettings28cdf476162496027c9b301bf30468cb.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
GlobalSettings28cdf476162496027c9b301bf30468cb.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: GlobalSettings28cdf476162496027c9b301bf30468cb.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
const GlobalSettings28cdf476162496027c9b301bf30468cbForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettings28cdf476162496027c9b301bf30468cb.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
GlobalSettings28cdf476162496027c9b301bf30468cbForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettings28cdf476162496027c9b301bf30468cb.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/reset-courses'
*/
GlobalSettings28cdf476162496027c9b301bf30468cbForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettings28cdf476162496027c9b301bf30468cb.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

GlobalSettings28cdf476162496027c9b301bf30468cb.form = GlobalSettings28cdf476162496027c9b301bf30468cbForm
/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
const GlobalSettingsfdc1627b9e2da467884f33613f26ccc3 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'get',
})

GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.definition = {
    methods: ["get","head"],
    url: '/global-settings/phishing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.url = (options?: RouteQueryOptions) => {
    return GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
const GlobalSettingsfdc1627b9e2da467884f33613f26ccc3Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
GlobalSettingsfdc1627b9e2da467884f33613f26ccc3Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings/phishing'
*/
GlobalSettingsfdc1627b9e2da467884f33613f26ccc3Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

GlobalSettingsfdc1627b9e2da467884f33613f26ccc3.form = GlobalSettingsfdc1627b9e2da467884f33613f26ccc3Form

const GlobalSettings = {
    '/global-settings': GlobalSettings84eaef77ed484e45d931ed7337b74dfe,
    '/global-settings/course-management': GlobalSettingsce0eb901513cf042a12cae43acdd20b9,
    '/global-settings/reset-courses': GlobalSettings28cdf476162496027c9b301bf30468cb,
    '/global-settings/phishing': GlobalSettingsfdc1627b9e2da467884f33613f26ccc3,
}

export default GlobalSettings