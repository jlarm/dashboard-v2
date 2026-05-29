import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived'
*/
const createe695fe70ff5de8e12d4c1a58d8b29494 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: createe695fe70ff5de8e12d4c1a58d8b29494.url(options),
    method: 'post',
})

createe695fe70ff5de8e12d4c1a58d8b29494.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets-archived',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived'
*/
createe695fe70ff5de8e12d4c1a58d8b29494.url = (options?: RouteQueryOptions) => {
    return createe695fe70ff5de8e12d4c1a58d8b29494.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived'
*/
createe695fe70ff5de8e12d4c1a58d8b29494.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: createe695fe70ff5de8e12d4c1a58d8b29494.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived/{individualAudit}/children'
*/
const create582a795d9d809cdf0da2fd23f265ce7c = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: create582a795d9d809cdf0da2fd23f265ce7c.url(args, options),
    method: 'post',
})

create582a795d9d809cdf0da2fd23f265ce7c.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets-archived/{individualAudit}/children',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived/{individualAudit}/children'
*/
create582a795d9d809cdf0da2fd23f265ce7c.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return create582a795d9d809cdf0da2fd23f265ce7c.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived/{individualAudit}/children'
*/
create582a795d9d809cdf0da2fd23f265ce7c.post = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: create582a795d9d809cdf0da2fd23f265ce7c.url(args, options),
    method: 'post',
})

/**
* Multiple routes resolve to \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create, so this export is a
* dictionary keyed by URI rather than a callable. Call a specific route with `create['<uri>'](...)`,
* or import the route by name from your generated `routes/` directory.
*/
export const create = {
    '/audits/deal-jackets-archived': createe695fe70ff5de8e12d4c1a58d8b29494,
    '/audits/deal-jackets-archived/{individualAudit}/children': create582a795d9d809cdf0da2fd23f265ce7c,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:68
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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:68
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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:68
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
edit.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:68
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
edit.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::update
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:83
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
export const update = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/audits/deal-jackets-archived/{individualAudit}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::update
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:83
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
update.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::update
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:83
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
update.patch = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:104
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
export const destroy = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/audits/deal-jackets-archived/{individualAudit}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:104
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
destroy.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:104
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
destroy.delete = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:123
* @route '/audits/deal-jackets-archived/{individualAudit}/generate'
*/
export const generate = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

generate.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets-archived/{individualAudit}/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:123
* @route '/audits/deal-jackets-archived/{individualAudit}/generate'
*/
generate.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return generate.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:123
* @route '/audits/deal-jackets-archived/{individualAudit}/generate'
*/
generate.post = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::index
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:31
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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::index
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:31
* @route '/audits/deal-jackets-archived'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::index
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:31
* @route '/audits/deal-jackets-archived'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::index
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:31
* @route '/audits/deal-jackets-archived'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::show
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:43
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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::show
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:43
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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::show
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:43
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
show.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::show
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:43
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
show.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::download
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:134
* @route '/audits/deal-jackets-archived/{individualAudit}/download'
*/
export const download = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets-archived/{individualAudit}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::download
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:134
* @route '/audits/deal-jackets-archived/{individualAudit}/download'
*/
download.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return download.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::download
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:134
* @route '/audits/deal-jackets-archived/{individualAudit}/download'
*/
download.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::download
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:134
* @route '/audits/deal-jackets-archived/{individualAudit}/download'
*/
download.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

const IndividualAuditController = { create, edit, update, destroy, generate, index, show, download }

export default IndividualAuditController