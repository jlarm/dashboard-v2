import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
const Show = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Show.url(args, options),
    method: 'get',
})

Show.definition = {
    methods: ["get","head"],
    url: '/phishing/{phishingCampaign}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
Show.url = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { phishingCampaign: args }
    }

    if (Array.isArray(args)) {
        args = {
            phishingCampaign: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        phishingCampaign: args.phishingCampaign,
    }

    return Show.definition.url
            .replace('{phishingCampaign}', parsedArgs.phishingCampaign.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
Show.get = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
Show.head = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
const ShowForm = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
ShowForm.get = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
ShowForm.head = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Show.form = ShowForm

export default Show