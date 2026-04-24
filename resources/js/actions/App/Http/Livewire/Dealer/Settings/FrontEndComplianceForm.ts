import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::__invoke
* @see app/Http/Livewire/Dealer/Settings/FrontEndComplianceForm.php:7
* @route '/email/settings'
*/
const FrontEndComplianceForm = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: FrontEndComplianceForm.url(options),
    method: 'get',
})

FrontEndComplianceForm.definition = {
    methods: ["get","head"],
    url: '/email/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::__invoke
* @see app/Http/Livewire/Dealer/Settings/FrontEndComplianceForm.php:7
* @route '/email/settings'
*/
FrontEndComplianceForm.url = (options?: RouteQueryOptions) => {
    return FrontEndComplianceForm.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::__invoke
* @see app/Http/Livewire/Dealer/Settings/FrontEndComplianceForm.php:7
* @route '/email/settings'
*/
FrontEndComplianceForm.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: FrontEndComplianceForm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::__invoke
* @see app/Http/Livewire/Dealer/Settings/FrontEndComplianceForm.php:7
* @route '/email/settings'
*/
FrontEndComplianceForm.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: FrontEndComplianceForm.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::__invoke
* @see app/Http/Livewire/Dealer/Settings/FrontEndComplianceForm.php:7
* @route '/email/settings'
*/
const FrontEndComplianceFormForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: FrontEndComplianceForm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::__invoke
* @see app/Http/Livewire/Dealer/Settings/FrontEndComplianceForm.php:7
* @route '/email/settings'
*/
FrontEndComplianceFormForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: FrontEndComplianceForm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Settings\FrontEndComplianceForm::__invoke
* @see app/Http/Livewire/Dealer/Settings/FrontEndComplianceForm.php:7
* @route '/email/settings'
*/
FrontEndComplianceFormForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: FrontEndComplianceForm.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

FrontEndComplianceForm.form = FrontEndComplianceFormForm

export default FrontEndComplianceForm