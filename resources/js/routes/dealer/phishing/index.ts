import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Livewire\Dealer\Phish\Create::__invoke
* @see app/Http/Livewire/Dealer/Phish/Create.php:7
* @route '/phishing/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/phishing/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Phish\Create::__invoke
* @see app/Http/Livewire/Dealer/Phish/Create.php:7
* @route '/phishing/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Phish\Create::__invoke
* @see app/Http/Livewire/Dealer/Phish/Create.php:7
* @route '/phishing/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Create::__invoke
* @see app/Http/Livewire/Dealer/Phish/Create.php:7
* @route '/phishing/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Create::__invoke
* @see app/Http/Livewire/Dealer/Phish/Create.php:7
* @route '/phishing/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Create::__invoke
* @see app/Http/Livewire/Dealer/Phish/Create.php:7
* @route '/phishing/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Create::__invoke
* @see app/Http/Livewire/Dealer/Phish/Create.php:7
* @route '/phishing/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/phishing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Index::__invoke
* @see app/Http/Livewire/Dealer/Phish/Index.php:7
* @route '/phishing'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
export const show = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/phishing/{phishingCampaign}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
show.url = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{phishingCampaign}', parsedArgs.phishingCampaign.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
show.get = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
show.head = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
const showForm = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
showForm.get = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Phish\Show::__invoke
* @see app/Http/Livewire/Dealer/Phish/Show.php:7
* @route '/phishing/{phishingCampaign}'
*/
showForm.head = (args: { phishingCampaign: string | number } | [phishingCampaign: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const phishing = {
    create: Object.assign(create, create),
    index: Object.assign(index, index),
    show: Object.assign(show, show),
}

export default phishing