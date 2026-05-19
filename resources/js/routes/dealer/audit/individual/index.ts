import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: create.url(options),
    method: 'post',
})

create.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets-archived',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived'
*/
create.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: create.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: create.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::create
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived'
*/
createForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: create.url(options),
    method: 'post',
})

create.form = createForm

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::createChild
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived/{individualAudit}/children'
*/
export const createChild = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: createChild.url(args, options),
    method: 'post',
})

createChild.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets-archived/{individualAudit}/children',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::createChild
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived/{individualAudit}/children'
*/
createChild.url = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return createChild.definition.url
            .replace('{individualAudit}', parsedArgs.individualAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::createChild
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived/{individualAudit}/children'
*/
createChild.post = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: createChild.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::createChild
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived/{individualAudit}/children'
*/
const createChildForm = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: createChild.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::createChild
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:52
* @route '/audits/deal-jackets-archived/{individualAudit}/children'
*/
createChildForm.post = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: createChild.url(args, options),
    method: 'post',
})

createChild.form = createChildForm

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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:68
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
const editForm = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:68
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
editForm.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:68
* @route '/audits/deal-jackets-archived/{individualAudit}/edit'
*/
editForm.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::update
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:83
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
const updateForm = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::update
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:83
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
updateForm.patch = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:104
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
const destroyForm = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:104
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
destroyForm.delete = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:123
* @route '/audits/deal-jackets-archived/{individualAudit}/generate'
*/
const generateForm = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:123
* @route '/audits/deal-jackets-archived/{individualAudit}/generate'
*/
generateForm.post = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generate.url(args, options),
    method: 'post',
})

generate.form = generateForm

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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::index
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:31
* @route '/audits/deal-jackets-archived'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::index
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:31
* @route '/audits/deal-jackets-archived'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::index
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:31
* @route '/audits/deal-jackets-archived'
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
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::show
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:43
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
const showForm = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::show
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:43
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
showForm.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::show
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:43
* @route '/audits/deal-jackets-archived/{individualAudit}'
*/
showForm.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

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

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::download
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:134
* @route '/audits/deal-jackets-archived/{individualAudit}/download'
*/
const downloadForm = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::download
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:134
* @route '/audits/deal-jackets-archived/{individualAudit}/download'
*/
downloadForm.get = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\IndividualAuditController::download
* @see app/Http/Controllers/Tenant/Audit/IndividualAuditController.php:134
* @route '/audits/deal-jackets-archived/{individualAudit}/download'
*/
downloadForm.head = (args: { individualAudit: string | number | { uuid: string | number } } | [individualAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

download.form = downloadForm

const individual = {
    create: Object.assign(create, create),
    createChild: Object.assign(createChild, createChild),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
    generate: Object.assign(generate, generate),
    index: Object.assign(index, index),
    show: Object.assign(show, show),
    download: Object.assign(download, download),
}

export default individual