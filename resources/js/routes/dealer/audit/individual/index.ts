import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults, validateParameters } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
export const create = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived/create/{individualAudit?}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
create.url = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { individualAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { individualAudit: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            individualAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    validateParameters(args, [
        "individualAudit",
    ])

    const parsedArgs = {
        individualAudit: typeof args?.individualAudit === 'object'
        ? args.individualAudit.id
        : args?.individualAudit,
    }

    return create.definition.url
            .replace('{individualAudit?}', parsedArgs.individualAudit?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
create.get = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualCreateController.php:15
* @route '/audits/deal-jackets-archived/create/{individualAudit?}'
*/
create.head = (args?: { individualAudit?: string | number | { id: string | number } } | [individualAudit: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualController.php:16
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
export const show = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived/{individualAudit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualController.php:16
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
show.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { individualAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { individualAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            individualAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        individualAudit: typeof args.individualAudit === 'object'
        ? args.individualAudit.uuid
        : args.individualAudit,
    }

    return show.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualController.php:16
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
show.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualController.php:16
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
show.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\SingleIndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/SingleIndividualController.php:17
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
export const edit = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived/{individualAudit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\SingleIndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/SingleIndividualController.php:17
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
edit.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { individualAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { individualAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            individualAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        individualAudit: typeof args.individualAudit === 'object'
        ? args.individualAudit.uuid
        : args.individualAudit,
    }

    return edit.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\SingleIndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/SingleIndividualController.php:17
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
edit.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\SingleIndividualController::__invoke
* @see app/Http/Controllers/Dealer/Audit/SingleIndividualController.php:17
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
edit.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualIndexController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualIndexController.php:13
* @route '/audits/deal-jackets-archived'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualIndexController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualIndexController.php:13
* @route '/audits/deal-jackets-archived'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualIndexController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualIndexController.php:13
* @route '/audits/deal-jackets-archived'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\IndividualIndexController::__invoke
* @see app/Http/Controllers/Dealer/Audit/IndividualIndexController.php:13
* @route '/audits/deal-jackets-archived'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const individual = {
    create: Object.assign(create, create),
    show: Object.assign(show, show),
    edit: Object.assign(edit, edit),
    index: Object.assign(index, index),
}

export default individual