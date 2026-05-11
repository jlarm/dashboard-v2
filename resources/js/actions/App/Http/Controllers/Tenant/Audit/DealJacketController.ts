import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:104
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
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:104
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
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:104
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
create.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:104
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
create.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:104
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
const createForm = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:104
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
createForm.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:104
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
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::store
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:144
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets'
*/
export const store = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets/{dealJacketGroup}/jackets',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::store
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:144
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets'
*/
store.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::store
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:144
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets'
*/
store.post = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::store
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:144
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets'
*/
const storeForm = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::store
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:144
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets'
*/
storeForm.post = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:123
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
export const edit = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:123
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.url = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions) => {
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
        dealJacket: args.dealJacket,
    }

    return edit.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace('{dealJacket}', parsedArgs.dealJacket.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:123
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.get = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:123
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.head = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:123
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
const editForm = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:123
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
editForm.get = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:123
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
editForm.head = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::update
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:158
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
export const update = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::update
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:158
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
update.url = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions) => {
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
        dealJacket: args.dealJacket,
    }

    return update.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace('{dealJacket}', parsedArgs.dealJacket.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::update
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:158
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
update.patch = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::update
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:158
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
const updateForm = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::update
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:158
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
updateForm.patch = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroy
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:174
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
export const destroy = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroy
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:174
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
destroy.url = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions) => {
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
        dealJacket: args.dealJacket,
    }

    return destroy.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace('{dealJacket}', parsedArgs.dealJacket.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroy
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:174
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
destroy.delete = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroy
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:174
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
const destroyForm = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroy
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:174
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
destroyForm.delete = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::startGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:52
* @route '/audits/deal-jackets'
*/
export const startGroup = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: startGroup.url(options),
    method: 'post',
})

startGroup.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::startGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:52
* @route '/audits/deal-jackets'
*/
startGroup.url = (options?: RouteQueryOptions) => {
    return startGroup.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::startGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:52
* @route '/audits/deal-jackets'
*/
startGroup.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: startGroup.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::startGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:52
* @route '/audits/deal-jackets'
*/
const startGroupForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: startGroup.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::startGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:52
* @route '/audits/deal-jackets'
*/
startGroupForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: startGroup.url(options),
    method: 'post',
})

startGroup.form = startGroupForm

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::complete
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:79
* @route '/audits/deal-jackets/{dealJacketGroup}/complete'
*/
export const complete = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: complete.url(args, options),
    method: 'post',
})

complete.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets/{dealJacketGroup}/complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::complete
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:79
* @route '/audits/deal-jackets/{dealJacketGroup}/complete'
*/
complete.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return complete.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::complete
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:79
* @route '/audits/deal-jackets/{dealJacketGroup}/complete'
*/
complete.post = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: complete.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::complete
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:79
* @route '/audits/deal-jackets/{dealJacketGroup}/complete'
*/
const completeForm = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: complete.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::complete
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:79
* @route '/audits/deal-jackets/{dealJacketGroup}/complete'
*/
completeForm.post = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: complete.url(args, options),
    method: 'post',
})

complete.form = completeForm

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroyGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:91
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
export const destroyGroup = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyGroup.url(args, options),
    method: 'delete',
})

destroyGroup.definition = {
    methods: ["delete"],
    url: '/audits/deal-jackets/{dealJacketGroup}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroyGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:91
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
destroyGroup.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return destroyGroup.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroyGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:91
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
destroyGroup.delete = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyGroup.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroyGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:91
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
const destroyGroupForm = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroyGroup.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroyGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:91
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
destroyGroupForm.delete = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroyGroup.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroyGroup.form = destroyGroupForm

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:32
* @route '/audits/deal-jackets'
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
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:70
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
export const show = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:70
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:70
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:70
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:70
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
const showForm = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:70
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
showForm.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:70
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
showForm.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const DealJacketController = { create, store, edit, update, destroy, startGroup, complete, destroyGroup, index, show }

export default DealJacketController