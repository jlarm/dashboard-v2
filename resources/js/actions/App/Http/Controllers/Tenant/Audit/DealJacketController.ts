import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:23
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
export const create = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:23
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
create.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealJacketGroup: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { dealJacketGroup: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
    }

    return create.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:23
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
create.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:23
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
create.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:23
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
const createForm = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:23
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
createForm.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:23
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
createForm.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
export const edit = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.url = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
            dealJacket: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
        dealJacket: typeof args.dealJacket === 'object'
        ? args.dealJacket.uuid
        : args.dealJacket,
    }

    return edit.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace('{dealJacket}', parsedArgs.dealJacket.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.get = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.head = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
const editForm = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
editForm.get = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
editForm.head = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:14
* @route '/audits/deal-jackets/{dealJacketGroup}/{dealJacket}'
*/
export const show = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}/{dealJacket}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:14
* @route '/audits/deal-jackets/{dealJacketGroup}/{dealJacket}'
*/
show.url = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
            dealJacket: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
        dealJacket: typeof args.dealJacket === 'object'
        ? args.dealJacket.uuid
        : args.dealJacket,
    }

    return show.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace('{dealJacket}', parsedArgs.dealJacket.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:14
* @route '/audits/deal-jackets/{dealJacketGroup}/{dealJacket}'
*/
show.get = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:14
* @route '/audits/deal-jackets/{dealJacketGroup}/{dealJacket}'
*/
show.head = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:14
* @route '/audits/deal-jackets/{dealJacketGroup}/{dealJacket}'
*/
const showForm = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:14
* @route '/audits/deal-jackets/{dealJacketGroup}/{dealJacket}'
*/
showForm.get = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:14
* @route '/audits/deal-jackets/{dealJacketGroup}/{dealJacket}'
*/
showForm.head = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number | { uuid: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const DealJacketController = { create, edit, show }

export default DealJacketController