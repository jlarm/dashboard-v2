import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
const AutomatedReports = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AutomatedReports.url(options),
    method: 'get',
})

AutomatedReports.definition = {
    methods: ["get","head"],
    url: '/automated-reports',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
AutomatedReports.url = (options?: RouteQueryOptions) => {
    return AutomatedReports.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
AutomatedReports.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AutomatedReports.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
AutomatedReports.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: AutomatedReports.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
const AutomatedReportsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AutomatedReports.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
AutomatedReportsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AutomatedReports.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\AutomatedReports::__invoke
* @see app/Http/Livewire/Dealer/Settings/AutomatedReports.php:7
* @route '/automated-reports'
*/
AutomatedReportsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: AutomatedReports.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

AutomatedReports.form = AutomatedReportsForm

export default AutomatedReports