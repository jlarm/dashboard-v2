import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
import global6b02c0 from './global'
/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
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
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
global.url = (options?: RouteQueryOptions) => {
    return global.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
global.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: global.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\GlobalSettings::__invoke
* @see app/Http/Livewire/Dealer/Settings/GlobalSettings.php:7
* @route '/global-settings'
*/
global.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: global.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
export const automatedReports = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: automatedReports.url(options),
    method: 'get',
})

automatedReports.definition = {
    methods: ["get","head"],
    url: '/automated-reports',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
automatedReports.url = (options?: RouteQueryOptions) => {
    return automatedReports.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
automatedReports.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: automatedReports.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
automatedReports.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: automatedReports.url(options),
    method: 'head',
})

const settings = {
    global: Object.assign(global, global6b02c0),
    automatedReports: Object.assign(automatedReports, automatedReports),
}

export default settings