import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/osha/create/{store}'
*/
const createa19409ccfc6014c0999bad13e08f4351 = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: createa19409ccfc6014c0999bad13e08f4351.url(args, options),
    method: 'get',
})

createa19409ccfc6014c0999bad13e08f4351.definition = {
    methods: ["get","head"],
    url: '/audits/osha/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/osha/create/{store}'
*/
createa19409ccfc6014c0999bad13e08f4351.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return createa19409ccfc6014c0999bad13e08f4351.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/osha/create/{store}'
*/
createa19409ccfc6014c0999bad13e08f4351.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: createa19409ccfc6014c0999bad13e08f4351.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/osha/create/{store}'
*/
createa19409ccfc6014c0999bad13e08f4351.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: createa19409ccfc6014c0999bad13e08f4351.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/osha/create/{store}'
*/
const createa19409ccfc6014c0999bad13e08f4351Form = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: createa19409ccfc6014c0999bad13e08f4351.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/osha/create/{store}'
*/
createa19409ccfc6014c0999bad13e08f4351Form.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: createa19409ccfc6014c0999bad13e08f4351.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/osha/create/{store}'
*/
createa19409ccfc6014c0999bad13e08f4351Form.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: createa19409ccfc6014c0999bad13e08f4351.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

createa19409ccfc6014c0999bad13e08f4351.form = createa19409ccfc6014c0999bad13e08f4351Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/body-shop/create/{store}'
*/
const createeab8b378eef1319663a9164a98b49968 = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: createeab8b378eef1319663a9164a98b49968.url(args, options),
    method: 'get',
})

createeab8b378eef1319663a9164a98b49968.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/body-shop/create/{store}'
*/
createeab8b378eef1319663a9164a98b49968.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return createeab8b378eef1319663a9164a98b49968.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/body-shop/create/{store}'
*/
createeab8b378eef1319663a9164a98b49968.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: createeab8b378eef1319663a9164a98b49968.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/body-shop/create/{store}'
*/
createeab8b378eef1319663a9164a98b49968.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: createeab8b378eef1319663a9164a98b49968.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/body-shop/create/{store}'
*/
const createeab8b378eef1319663a9164a98b49968Form = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: createeab8b378eef1319663a9164a98b49968.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/body-shop/create/{store}'
*/
createeab8b378eef1319663a9164a98b49968Form.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: createeab8b378eef1319663a9164a98b49968.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/body-shop/create/{store}'
*/
createeab8b378eef1319663a9164a98b49968Form.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: createeab8b378eef1319663a9164a98b49968.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

createeab8b378eef1319663a9164a98b49968.form = createeab8b378eef1319663a9164a98b49968Form

export const create = {
    '/audits/osha/create/{store}': createa19409ccfc6014c0999bad13e08f4351,
    '/audits/body-shop/create/{store}': createeab8b378eef1319663a9164a98b49968,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/osha/{audit}/edit'
*/
const edit7c9609eb981a8166fcdbba858e5f6028 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit7c9609eb981a8166fcdbba858e5f6028.url(args, options),
    method: 'get',
})

edit7c9609eb981a8166fcdbba858e5f6028.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/osha/{audit}/edit'
*/
edit7c9609eb981a8166fcdbba858e5f6028.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return edit7c9609eb981a8166fcdbba858e5f6028.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/osha/{audit}/edit'
*/
edit7c9609eb981a8166fcdbba858e5f6028.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit7c9609eb981a8166fcdbba858e5f6028.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/osha/{audit}/edit'
*/
edit7c9609eb981a8166fcdbba858e5f6028.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit7c9609eb981a8166fcdbba858e5f6028.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/osha/{audit}/edit'
*/
const edit7c9609eb981a8166fcdbba858e5f6028Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit7c9609eb981a8166fcdbba858e5f6028.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/osha/{audit}/edit'
*/
edit7c9609eb981a8166fcdbba858e5f6028Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit7c9609eb981a8166fcdbba858e5f6028.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/osha/{audit}/edit'
*/
edit7c9609eb981a8166fcdbba858e5f6028Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit7c9609eb981a8166fcdbba858e5f6028.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit7c9609eb981a8166fcdbba858e5f6028.form = edit7c9609eb981a8166fcdbba858e5f6028Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/body-shop/{audit}/edit'
*/
const edit2c26a599a0d67c565351c47e534213bf = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit2c26a599a0d67c565351c47e534213bf.url(args, options),
    method: 'get',
})

edit2c26a599a0d67c565351c47e534213bf.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{audit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/body-shop/{audit}/edit'
*/
edit2c26a599a0d67c565351c47e534213bf.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return edit2c26a599a0d67c565351c47e534213bf.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/body-shop/{audit}/edit'
*/
edit2c26a599a0d67c565351c47e534213bf.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit2c26a599a0d67c565351c47e534213bf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/body-shop/{audit}/edit'
*/
edit2c26a599a0d67c565351c47e534213bf.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit2c26a599a0d67c565351c47e534213bf.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/body-shop/{audit}/edit'
*/
const edit2c26a599a0d67c565351c47e534213bfForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit2c26a599a0d67c565351c47e534213bf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/body-shop/{audit}/edit'
*/
edit2c26a599a0d67c565351c47e534213bfForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit2c26a599a0d67c565351c47e534213bf.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/body-shop/{audit}/edit'
*/
edit2c26a599a0d67c565351c47e534213bfForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit2c26a599a0d67c565351c47e534213bf.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit2c26a599a0d67c565351c47e534213bf.form = edit2c26a599a0d67c565351c47e534213bfForm

export const edit = {
    '/audits/osha/{audit}/edit': edit7c9609eb981a8166fcdbba858e5f6028,
    '/audits/body-shop/{audit}/edit': edit2c26a599a0d67c565351c47e534213bf,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/osha/{audit}'
*/
const update7dc6084cd011454356fdc072c2fdd700 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'patch',
})

update7dc6084cd011454356fdc072c2fdd700.definition = {
    methods: ["patch"],
    url: '/audits/osha/{audit}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/osha/{audit}'
*/
update7dc6084cd011454356fdc072c2fdd700.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return update7dc6084cd011454356fdc072c2fdd700.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/osha/{audit}'
*/
update7dc6084cd011454356fdc072c2fdd700.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/osha/{audit}'
*/
const update7dc6084cd011454356fdc072c2fdd700Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update7dc6084cd011454356fdc072c2fdd700.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/osha/{audit}'
*/
update7dc6084cd011454356fdc072c2fdd700Form.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update7dc6084cd011454356fdc072c2fdd700.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update7dc6084cd011454356fdc072c2fdd700.form = update7dc6084cd011454356fdc072c2fdd700Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/body-shop/{audit}'
*/
const update5494c3ad34cb44680b965023d444ac2e = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'patch',
})

update5494c3ad34cb44680b965023d444ac2e.definition = {
    methods: ["patch"],
    url: '/audits/body-shop/{audit}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/body-shop/{audit}'
*/
update5494c3ad34cb44680b965023d444ac2e.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return update5494c3ad34cb44680b965023d444ac2e.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/body-shop/{audit}'
*/
update5494c3ad34cb44680b965023d444ac2e.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/body-shop/{audit}'
*/
const update5494c3ad34cb44680b965023d444ac2eForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update5494c3ad34cb44680b965023d444ac2e.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/body-shop/{audit}'
*/
update5494c3ad34cb44680b965023d444ac2eForm.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update5494c3ad34cb44680b965023d444ac2e.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update5494c3ad34cb44680b965023d444ac2e.form = update5494c3ad34cb44680b965023d444ac2eForm

export const update = {
    '/audits/osha/{audit}': update7dc6084cd011454356fdc072c2fdd700,
    '/audits/body-shop/{audit}': update5494c3ad34cb44680b965023d444ac2e,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/osha/{audit}'
*/
const destroy7dc6084cd011454356fdc072c2fdd700 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'delete',
})

destroy7dc6084cd011454356fdc072c2fdd700.definition = {
    methods: ["delete"],
    url: '/audits/osha/{audit}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/osha/{audit}'
*/
destroy7dc6084cd011454356fdc072c2fdd700.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return destroy7dc6084cd011454356fdc072c2fdd700.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/osha/{audit}'
*/
destroy7dc6084cd011454356fdc072c2fdd700.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/osha/{audit}'
*/
const destroy7dc6084cd011454356fdc072c2fdd700Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy7dc6084cd011454356fdc072c2fdd700.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/osha/{audit}'
*/
destroy7dc6084cd011454356fdc072c2fdd700Form.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy7dc6084cd011454356fdc072c2fdd700.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy7dc6084cd011454356fdc072c2fdd700.form = destroy7dc6084cd011454356fdc072c2fdd700Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/body-shop/{audit}'
*/
const destroy5494c3ad34cb44680b965023d444ac2e = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'delete',
})

destroy5494c3ad34cb44680b965023d444ac2e.definition = {
    methods: ["delete"],
    url: '/audits/body-shop/{audit}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/body-shop/{audit}'
*/
destroy5494c3ad34cb44680b965023d444ac2e.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return destroy5494c3ad34cb44680b965023d444ac2e.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/body-shop/{audit}'
*/
destroy5494c3ad34cb44680b965023d444ac2e.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/body-shop/{audit}'
*/
const destroy5494c3ad34cb44680b965023d444ac2eForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy5494c3ad34cb44680b965023d444ac2e.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/body-shop/{audit}'
*/
destroy5494c3ad34cb44680b965023d444ac2eForm.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy5494c3ad34cb44680b965023d444ac2e.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy5494c3ad34cb44680b965023d444ac2e.form = destroy5494c3ad34cb44680b965023d444ac2eForm

export const destroy = {
    '/audits/osha/{audit}': destroy7dc6084cd011454356fdc072c2fdd700,
    '/audits/body-shop/{audit}': destroy5494c3ad34cb44680b965023d444ac2e,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/osha/{audit}/grade'
*/
const updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.url(args, options),
    method: 'patch',
})

updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.definition = {
    methods: ["patch"],
    url: '/audits/osha/{audit}/grade',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/osha/{audit}/grade'
*/
updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/osha/{audit}/grade'
*/
updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/osha/{audit}/grade'
*/
const updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/osha/{audit}/grade'
*/
updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1Form.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1.form = updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/body-shop/{audit}/grade'
*/
const updateGrade30867501be91149b851244a751243036 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateGrade30867501be91149b851244a751243036.url(args, options),
    method: 'patch',
})

updateGrade30867501be91149b851244a751243036.definition = {
    methods: ["patch"],
    url: '/audits/body-shop/{audit}/grade',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/body-shop/{audit}/grade'
*/
updateGrade30867501be91149b851244a751243036.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return updateGrade30867501be91149b851244a751243036.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/body-shop/{audit}/grade'
*/
updateGrade30867501be91149b851244a751243036.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateGrade30867501be91149b851244a751243036.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/body-shop/{audit}/grade'
*/
const updateGrade30867501be91149b851244a751243036Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateGrade30867501be91149b851244a751243036.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/body-shop/{audit}/grade'
*/
updateGrade30867501be91149b851244a751243036Form.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateGrade30867501be91149b851244a751243036.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateGrade30867501be91149b851244a751243036.form = updateGrade30867501be91149b851244a751243036Form

export const updateGrade = {
    '/audits/osha/{audit}/grade': updateGrade68715a6e898e7ed5f1dbcb73d7ee4fe1,
    '/audits/body-shop/{audit}/grade': updateGrade30867501be91149b851244a751243036,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/osha/{audit}/complete'
*/
const completeedde5b52a31e271d3f8756008a39c17f = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: completeedde5b52a31e271d3f8756008a39c17f.url(args, options),
    method: 'post',
})

completeedde5b52a31e271d3f8756008a39c17f.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/osha/{audit}/complete'
*/
completeedde5b52a31e271d3f8756008a39c17f.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return completeedde5b52a31e271d3f8756008a39c17f.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/osha/{audit}/complete'
*/
completeedde5b52a31e271d3f8756008a39c17f.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: completeedde5b52a31e271d3f8756008a39c17f.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/osha/{audit}/complete'
*/
const completeedde5b52a31e271d3f8756008a39c17fForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: completeedde5b52a31e271d3f8756008a39c17f.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/osha/{audit}/complete'
*/
completeedde5b52a31e271d3f8756008a39c17fForm.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: completeedde5b52a31e271d3f8756008a39c17f.url(args, options),
    method: 'post',
})

completeedde5b52a31e271d3f8756008a39c17f.form = completeedde5b52a31e271d3f8756008a39c17fForm
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/body-shop/{audit}/complete'
*/
const completec9d1947949fb6136cdc46477836f8203 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: completec9d1947949fb6136cdc46477836f8203.url(args, options),
    method: 'post',
})

completec9d1947949fb6136cdc46477836f8203.definition = {
    methods: ["post"],
    url: '/audits/body-shop/{audit}/complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/body-shop/{audit}/complete'
*/
completec9d1947949fb6136cdc46477836f8203.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return completec9d1947949fb6136cdc46477836f8203.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/body-shop/{audit}/complete'
*/
completec9d1947949fb6136cdc46477836f8203.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: completec9d1947949fb6136cdc46477836f8203.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/body-shop/{audit}/complete'
*/
const completec9d1947949fb6136cdc46477836f8203Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: completec9d1947949fb6136cdc46477836f8203.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/body-shop/{audit}/complete'
*/
completec9d1947949fb6136cdc46477836f8203Form.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: completec9d1947949fb6136cdc46477836f8203.url(args, options),
    method: 'post',
})

completec9d1947949fb6136cdc46477836f8203.form = completec9d1947949fb6136cdc46477836f8203Form

export const complete = {
    '/audits/osha/{audit}/complete': completeedde5b52a31e271d3f8756008a39c17f,
    '/audits/body-shop/{audit}/complete': completec9d1947949fb6136cdc46477836f8203,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/osha/{audit}/complete'
*/
const reopenedde5b52a31e271d3f8756008a39c17f = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: reopenedde5b52a31e271d3f8756008a39c17f.url(args, options),
    method: 'delete',
})

reopenedde5b52a31e271d3f8756008a39c17f.definition = {
    methods: ["delete"],
    url: '/audits/osha/{audit}/complete',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/osha/{audit}/complete'
*/
reopenedde5b52a31e271d3f8756008a39c17f.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return reopenedde5b52a31e271d3f8756008a39c17f.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/osha/{audit}/complete'
*/
reopenedde5b52a31e271d3f8756008a39c17f.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: reopenedde5b52a31e271d3f8756008a39c17f.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/osha/{audit}/complete'
*/
const reopenedde5b52a31e271d3f8756008a39c17fForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: reopenedde5b52a31e271d3f8756008a39c17f.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/osha/{audit}/complete'
*/
reopenedde5b52a31e271d3f8756008a39c17fForm.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: reopenedde5b52a31e271d3f8756008a39c17f.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

reopenedde5b52a31e271d3f8756008a39c17f.form = reopenedde5b52a31e271d3f8756008a39c17fForm
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/body-shop/{audit}/complete'
*/
const reopenc9d1947949fb6136cdc46477836f8203 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: reopenc9d1947949fb6136cdc46477836f8203.url(args, options),
    method: 'delete',
})

reopenc9d1947949fb6136cdc46477836f8203.definition = {
    methods: ["delete"],
    url: '/audits/body-shop/{audit}/complete',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/body-shop/{audit}/complete'
*/
reopenc9d1947949fb6136cdc46477836f8203.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return reopenc9d1947949fb6136cdc46477836f8203.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/body-shop/{audit}/complete'
*/
reopenc9d1947949fb6136cdc46477836f8203.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: reopenc9d1947949fb6136cdc46477836f8203.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/body-shop/{audit}/complete'
*/
const reopenc9d1947949fb6136cdc46477836f8203Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: reopenc9d1947949fb6136cdc46477836f8203.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/body-shop/{audit}/complete'
*/
reopenc9d1947949fb6136cdc46477836f8203Form.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: reopenc9d1947949fb6136cdc46477836f8203.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

reopenc9d1947949fb6136cdc46477836f8203.form = reopenc9d1947949fb6136cdc46477836f8203Form

export const reopen = {
    '/audits/osha/{audit}/complete': reopenedde5b52a31e271d3f8756008a39c17f,
    '/audits/body-shop/{audit}/complete': reopenc9d1947949fb6136cdc46477836f8203,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/osha/{audit}/violations'
*/
const addViolation19592905b071e8a7bfdb91fc40cf0cd7 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: addViolation19592905b071e8a7bfdb91fc40cf0cd7.url(args, options),
    method: 'post',
})

addViolation19592905b071e8a7bfdb91fc40cf0cd7.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/violations',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/osha/{audit}/violations'
*/
addViolation19592905b071e8a7bfdb91fc40cf0cd7.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return addViolation19592905b071e8a7bfdb91fc40cf0cd7.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/osha/{audit}/violations'
*/
addViolation19592905b071e8a7bfdb91fc40cf0cd7.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: addViolation19592905b071e8a7bfdb91fc40cf0cd7.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/osha/{audit}/violations'
*/
const addViolation19592905b071e8a7bfdb91fc40cf0cd7Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: addViolation19592905b071e8a7bfdb91fc40cf0cd7.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/osha/{audit}/violations'
*/
addViolation19592905b071e8a7bfdb91fc40cf0cd7Form.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: addViolation19592905b071e8a7bfdb91fc40cf0cd7.url(args, options),
    method: 'post',
})

addViolation19592905b071e8a7bfdb91fc40cf0cd7.form = addViolation19592905b071e8a7bfdb91fc40cf0cd7Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/body-shop/{audit}/violations'
*/
const addViolationd5e6bb5c9152f0b1fdac1b4069e6def5 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.url(args, options),
    method: 'post',
})

addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.definition = {
    methods: ["post"],
    url: '/audits/body-shop/{audit}/violations',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/body-shop/{audit}/violations'
*/
addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/body-shop/{audit}/violations'
*/
addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/body-shop/{audit}/violations'
*/
const addViolationd5e6bb5c9152f0b1fdac1b4069e6def5Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:213
* @route '/audits/body-shop/{audit}/violations'
*/
addViolationd5e6bb5c9152f0b1fdac1b4069e6def5Form.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.url(args, options),
    method: 'post',
})

addViolationd5e6bb5c9152f0b1fdac1b4069e6def5.form = addViolationd5e6bb5c9152f0b1fdac1b4069e6def5Form

export const addViolation = {
    '/audits/osha/{audit}/violations': addViolation19592905b071e8a7bfdb91fc40cf0cd7,
    '/audits/body-shop/{audit}/violations': addViolationd5e6bb5c9152f0b1fdac1b4069e6def5,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/osha/{audit}/violations/{violation}'
*/
const deleteViolationd4a728e4d1fe83a42b9db266291997a2 = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolationd4a728e4d1fe83a42b9db266291997a2.url(args, options),
    method: 'delete',
})

deleteViolationd4a728e4d1fe83a42b9db266291997a2.definition = {
    methods: ["delete"],
    url: '/audits/osha/{audit}/violations/{violation}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/osha/{audit}/violations/{violation}'
*/
deleteViolationd4a728e4d1fe83a42b9db266291997a2.url = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            violation: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        violation: typeof args.violation === 'object'
        ? args.violation.id
        : args.violation,
    }

    return deleteViolationd4a728e4d1fe83a42b9db266291997a2.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{violation}', parsedArgs.violation.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/osha/{audit}/violations/{violation}'
*/
deleteViolationd4a728e4d1fe83a42b9db266291997a2.delete = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolationd4a728e4d1fe83a42b9db266291997a2.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/osha/{audit}/violations/{violation}'
*/
const deleteViolationd4a728e4d1fe83a42b9db266291997a2Form = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolationd4a728e4d1fe83a42b9db266291997a2.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/osha/{audit}/violations/{violation}'
*/
deleteViolationd4a728e4d1fe83a42b9db266291997a2Form.delete = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolationd4a728e4d1fe83a42b9db266291997a2.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

deleteViolationd4a728e4d1fe83a42b9db266291997a2.form = deleteViolationd4a728e4d1fe83a42b9db266291997a2Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
const deleteViolation87f16af0c5f044b1d12335ddb0a05fed = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolation87f16af0c5f044b1d12335ddb0a05fed.url(args, options),
    method: 'delete',
})

deleteViolation87f16af0c5f044b1d12335ddb0a05fed.definition = {
    methods: ["delete"],
    url: '/audits/body-shop/{audit}/violations/{violation}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
deleteViolation87f16af0c5f044b1d12335ddb0a05fed.url = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            violation: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        violation: typeof args.violation === 'object'
        ? args.violation.id
        : args.violation,
    }

    return deleteViolation87f16af0c5f044b1d12335ddb0a05fed.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{violation}', parsedArgs.violation.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
deleteViolation87f16af0c5f044b1d12335ddb0a05fed.delete = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolation87f16af0c5f044b1d12335ddb0a05fed.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
const deleteViolation87f16af0c5f044b1d12335ddb0a05fedForm = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolation87f16af0c5f044b1d12335ddb0a05fed.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:227
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
deleteViolation87f16af0c5f044b1d12335ddb0a05fedForm.delete = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolation87f16af0c5f044b1d12335ddb0a05fed.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

deleteViolation87f16af0c5f044b1d12335ddb0a05fed.form = deleteViolation87f16af0c5f044b1d12335ddb0a05fedForm

export const deleteViolation = {
    '/audits/osha/{audit}/violations/{violation}': deleteViolationd4a728e4d1fe83a42b9db266291997a2,
    '/audits/body-shop/{audit}/violations/{violation}': deleteViolation87f16af0c5f044b1d12335ddb0a05fed,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
const deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3 = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.url(args, options),
    method: 'delete',
})

deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.definition = {
    methods: ["delete"],
    url: '/audits/osha/{audit}/violations/{violation}/photos/{photoId}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.url = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            violation: args[1],
            photoId: args[2],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        violation: typeof args.violation === 'object'
        ? args.violation.id
        : args.violation,
        photoId: args.photoId,
    }

    return deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{violation}', parsedArgs.violation.toString())
            .replace('{photoId}', parsedArgs.photoId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.delete = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
const deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3Form = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3Form.delete = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3.form = deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}'
*/
const deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451 = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.url(args, options),
    method: 'delete',
})

deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.definition = {
    methods: ["delete"],
    url: '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.url = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            violation: args[1],
            photoId: args[2],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        violation: typeof args.violation === 'object'
        ? args.violation.id
        : args.violation,
        photoId: args.photoId,
    }

    return deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{violation}', parsedArgs.violation.toString())
            .replace('{photoId}', parsedArgs.photoId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.delete = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}'
*/
const deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451Form = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451Form.delete = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451.form = deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451Form

export const deleteViolationPhoto = {
    '/audits/osha/{audit}/violations/{violation}/photos/{photoId}': deleteViolationPhoto54c949bd3b72407cac6d3348bf1560b3,
    '/audits/body-shop/{audit}/violations/{violation}/photos/{photoId}': deleteViolationPhotodf7ebe293522a355637c5b31e6e0f451,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/osha/{audit}/generate'
*/
const generateed3e169eecb74af4b798c60300a9a84b = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateed3e169eecb74af4b798c60300a9a84b.url(args, options),
    method: 'post',
})

generateed3e169eecb74af4b798c60300a9a84b.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/osha/{audit}/generate'
*/
generateed3e169eecb74af4b798c60300a9a84b.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return generateed3e169eecb74af4b798c60300a9a84b.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/osha/{audit}/generate'
*/
generateed3e169eecb74af4b798c60300a9a84b.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateed3e169eecb74af4b798c60300a9a84b.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/osha/{audit}/generate'
*/
const generateed3e169eecb74af4b798c60300a9a84bForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateed3e169eecb74af4b798c60300a9a84b.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/osha/{audit}/generate'
*/
generateed3e169eecb74af4b798c60300a9a84bForm.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateed3e169eecb74af4b798c60300a9a84b.url(args, options),
    method: 'post',
})

generateed3e169eecb74af4b798c60300a9a84b.form = generateed3e169eecb74af4b798c60300a9a84bForm
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/body-shop/{audit}/generate'
*/
const generateb99b1c9c928a88accba790332ad8c8e8 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateb99b1c9c928a88accba790332ad8c8e8.url(args, options),
    method: 'post',
})

generateb99b1c9c928a88accba790332ad8c8e8.definition = {
    methods: ["post"],
    url: '/audits/body-shop/{audit}/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/body-shop/{audit}/generate'
*/
generateb99b1c9c928a88accba790332ad8c8e8.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return generateb99b1c9c928a88accba790332ad8c8e8.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/body-shop/{audit}/generate'
*/
generateb99b1c9c928a88accba790332ad8c8e8.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateb99b1c9c928a88accba790332ad8c8e8.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/body-shop/{audit}/generate'
*/
const generateb99b1c9c928a88accba790332ad8c8e8Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateb99b1c9c928a88accba790332ad8c8e8.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/body-shop/{audit}/generate'
*/
generateb99b1c9c928a88accba790332ad8c8e8Form.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateb99b1c9c928a88accba790332ad8c8e8.url(args, options),
    method: 'post',
})

generateb99b1c9c928a88accba790332ad8c8e8.form = generateb99b1c9c928a88accba790332ad8c8e8Form

export const generate = {
    '/audits/osha/{audit}/generate': generateed3e169eecb74af4b798c60300a9a84b,
    '/audits/body-shop/{audit}/generate': generateb99b1c9c928a88accba790332ad8c8e8,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/osha/{audit}/remediation/generate'
*/
const generateRemediation07352172e7421dc2b841f14ea7057970 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateRemediation07352172e7421dc2b841f14ea7057970.url(args, options),
    method: 'post',
})

generateRemediation07352172e7421dc2b841f14ea7057970.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/remediation/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/osha/{audit}/remediation/generate'
*/
generateRemediation07352172e7421dc2b841f14ea7057970.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return generateRemediation07352172e7421dc2b841f14ea7057970.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/osha/{audit}/remediation/generate'
*/
generateRemediation07352172e7421dc2b841f14ea7057970.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateRemediation07352172e7421dc2b841f14ea7057970.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/osha/{audit}/remediation/generate'
*/
const generateRemediation07352172e7421dc2b841f14ea7057970Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateRemediation07352172e7421dc2b841f14ea7057970.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/osha/{audit}/remediation/generate'
*/
generateRemediation07352172e7421dc2b841f14ea7057970Form.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateRemediation07352172e7421dc2b841f14ea7057970.url(args, options),
    method: 'post',
})

generateRemediation07352172e7421dc2b841f14ea7057970.form = generateRemediation07352172e7421dc2b841f14ea7057970Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/body-shop/{audit}/remediation/generate'
*/
const generateRemediation1f05dddb06555519d680fcb273bc2b53 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateRemediation1f05dddb06555519d680fcb273bc2b53.url(args, options),
    method: 'post',
})

generateRemediation1f05dddb06555519d680fcb273bc2b53.definition = {
    methods: ["post"],
    url: '/audits/body-shop/{audit}/remediation/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/body-shop/{audit}/remediation/generate'
*/
generateRemediation1f05dddb06555519d680fcb273bc2b53.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return generateRemediation1f05dddb06555519d680fcb273bc2b53.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/body-shop/{audit}/remediation/generate'
*/
generateRemediation1f05dddb06555519d680fcb273bc2b53.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateRemediation1f05dddb06555519d680fcb273bc2b53.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/body-shop/{audit}/remediation/generate'
*/
const generateRemediation1f05dddb06555519d680fcb273bc2b53Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateRemediation1f05dddb06555519d680fcb273bc2b53.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:314
* @route '/audits/body-shop/{audit}/remediation/generate'
*/
generateRemediation1f05dddb06555519d680fcb273bc2b53Form.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateRemediation1f05dddb06555519d680fcb273bc2b53.url(args, options),
    method: 'post',
})

generateRemediation1f05dddb06555519d680fcb273bc2b53.form = generateRemediation1f05dddb06555519d680fcb273bc2b53Form

export const generateRemediation = {
    '/audits/osha/{audit}/remediation/generate': generateRemediation07352172e7421dc2b841f14ea7057970,
    '/audits/body-shop/{audit}/remediation/generate': generateRemediation1f05dddb06555519d680fcb273bc2b53,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/osha/{audit}/violations/search'
*/
const searchStatements791c591190ae7a016f8809d7c0868486 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchStatements791c591190ae7a016f8809d7c0868486.url(args, options),
    method: 'get',
})

searchStatements791c591190ae7a016f8809d7c0868486.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/violations/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatements791c591190ae7a016f8809d7c0868486.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return searchStatements791c591190ae7a016f8809d7c0868486.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatements791c591190ae7a016f8809d7c0868486.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchStatements791c591190ae7a016f8809d7c0868486.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatements791c591190ae7a016f8809d7c0868486.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: searchStatements791c591190ae7a016f8809d7c0868486.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/osha/{audit}/violations/search'
*/
const searchStatements791c591190ae7a016f8809d7c0868486Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatements791c591190ae7a016f8809d7c0868486.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatements791c591190ae7a016f8809d7c0868486Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatements791c591190ae7a016f8809d7c0868486.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatements791c591190ae7a016f8809d7c0868486Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatements791c591190ae7a016f8809d7c0868486.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

searchStatements791c591190ae7a016f8809d7c0868486.form = searchStatements791c591190ae7a016f8809d7c0868486Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/body-shop/{audit}/violations/search'
*/
const searchStatementsaea60cea259f2c6f97a7b596ceed754f = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchStatementsaea60cea259f2c6f97a7b596ceed754f.url(args, options),
    method: 'get',
})

searchStatementsaea60cea259f2c6f97a7b596ceed754f.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{audit}/violations/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/body-shop/{audit}/violations/search'
*/
searchStatementsaea60cea259f2c6f97a7b596ceed754f.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return searchStatementsaea60cea259f2c6f97a7b596ceed754f.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/body-shop/{audit}/violations/search'
*/
searchStatementsaea60cea259f2c6f97a7b596ceed754f.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchStatementsaea60cea259f2c6f97a7b596ceed754f.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/body-shop/{audit}/violations/search'
*/
searchStatementsaea60cea259f2c6f97a7b596ceed754f.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: searchStatementsaea60cea259f2c6f97a7b596ceed754f.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/body-shop/{audit}/violations/search'
*/
const searchStatementsaea60cea259f2c6f97a7b596ceed754fForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatementsaea60cea259f2c6f97a7b596ceed754f.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/body-shop/{audit}/violations/search'
*/
searchStatementsaea60cea259f2c6f97a7b596ceed754fForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatementsaea60cea259f2c6f97a7b596ceed754f.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:260
* @route '/audits/body-shop/{audit}/violations/search'
*/
searchStatementsaea60cea259f2c6f97a7b596ceed754fForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatementsaea60cea259f2c6f97a7b596ceed754f.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

searchStatementsaea60cea259f2c6f97a7b596ceed754f.form = searchStatementsaea60cea259f2c6f97a7b596ceed754fForm

export const searchStatements = {
    '/audits/osha/{audit}/violations/search': searchStatements791c591190ae7a016f8809d7c0868486,
    '/audits/body-shop/{audit}/violations/search': searchStatementsaea60cea259f2c6f97a7b596ceed754f,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/osha'
*/
const index0ca236db944c47c98c6103ba2da2adbc = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index0ca236db944c47c98c6103ba2da2adbc.url(options),
    method: 'get',
})

index0ca236db944c47c98c6103ba2da2adbc.definition = {
    methods: ["get","head"],
    url: '/audits/osha',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/osha'
*/
index0ca236db944c47c98c6103ba2da2adbc.url = (options?: RouteQueryOptions) => {
    return index0ca236db944c47c98c6103ba2da2adbc.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/osha'
*/
index0ca236db944c47c98c6103ba2da2adbc.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index0ca236db944c47c98c6103ba2da2adbc.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/osha'
*/
index0ca236db944c47c98c6103ba2da2adbc.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index0ca236db944c47c98c6103ba2da2adbc.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/osha'
*/
const index0ca236db944c47c98c6103ba2da2adbcForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index0ca236db944c47c98c6103ba2da2adbc.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/osha'
*/
index0ca236db944c47c98c6103ba2da2adbcForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index0ca236db944c47c98c6103ba2da2adbc.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/osha'
*/
index0ca236db944c47c98c6103ba2da2adbcForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index0ca236db944c47c98c6103ba2da2adbc.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index0ca236db944c47c98c6103ba2da2adbc.form = index0ca236db944c47c98c6103ba2da2adbcForm
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/body-shop'
*/
const indexf9470c0514ca7d1ea93296fdf4d14cce = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexf9470c0514ca7d1ea93296fdf4d14cce.url(options),
    method: 'get',
})

indexf9470c0514ca7d1ea93296fdf4d14cce.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/body-shop'
*/
indexf9470c0514ca7d1ea93296fdf4d14cce.url = (options?: RouteQueryOptions) => {
    return indexf9470c0514ca7d1ea93296fdf4d14cce.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/body-shop'
*/
indexf9470c0514ca7d1ea93296fdf4d14cce.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexf9470c0514ca7d1ea93296fdf4d14cce.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/body-shop'
*/
indexf9470c0514ca7d1ea93296fdf4d14cce.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: indexf9470c0514ca7d1ea93296fdf4d14cce.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/body-shop'
*/
const indexf9470c0514ca7d1ea93296fdf4d14cceForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexf9470c0514ca7d1ea93296fdf4d14cce.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/body-shop'
*/
indexf9470c0514ca7d1ea93296fdf4d14cceForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexf9470c0514ca7d1ea93296fdf4d14cce.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/body-shop'
*/
indexf9470c0514ca7d1ea93296fdf4d14cceForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: indexf9470c0514ca7d1ea93296fdf4d14cce.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

indexf9470c0514ca7d1ea93296fdf4d14cce.form = indexf9470c0514ca7d1ea93296fdf4d14cceForm

export const index = {
    '/audits/osha': index0ca236db944c47c98c6103ba2da2adbc,
    '/audits/body-shop': indexf9470c0514ca7d1ea93296fdf4d14cce,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/osha/{audit}/remediation'
*/
const remediation4a1236e49e13c58592c97bab56d4eb04 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation4a1236e49e13c58592c97bab56d4eb04.url(args, options),
    method: 'get',
})

remediation4a1236e49e13c58592c97bab56d4eb04.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/osha/{audit}/remediation'
*/
remediation4a1236e49e13c58592c97bab56d4eb04.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return remediation4a1236e49e13c58592c97bab56d4eb04.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/osha/{audit}/remediation'
*/
remediation4a1236e49e13c58592c97bab56d4eb04.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation4a1236e49e13c58592c97bab56d4eb04.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/osha/{audit}/remediation'
*/
remediation4a1236e49e13c58592c97bab56d4eb04.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: remediation4a1236e49e13c58592c97bab56d4eb04.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/osha/{audit}/remediation'
*/
const remediation4a1236e49e13c58592c97bab56d4eb04Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation4a1236e49e13c58592c97bab56d4eb04.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/osha/{audit}/remediation'
*/
remediation4a1236e49e13c58592c97bab56d4eb04Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation4a1236e49e13c58592c97bab56d4eb04.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/osha/{audit}/remediation'
*/
remediation4a1236e49e13c58592c97bab56d4eb04Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation4a1236e49e13c58592c97bab56d4eb04.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

remediation4a1236e49e13c58592c97bab56d4eb04.form = remediation4a1236e49e13c58592c97bab56d4eb04Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/body-shop/{audit}/remediation'
*/
const remediation522c5d19d260615771b93186f2cc4431 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation522c5d19d260615771b93186f2cc4431.url(args, options),
    method: 'get',
})

remediation522c5d19d260615771b93186f2cc4431.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{audit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/body-shop/{audit}/remediation'
*/
remediation522c5d19d260615771b93186f2cc4431.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return remediation522c5d19d260615771b93186f2cc4431.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/body-shop/{audit}/remediation'
*/
remediation522c5d19d260615771b93186f2cc4431.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation522c5d19d260615771b93186f2cc4431.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/body-shop/{audit}/remediation'
*/
remediation522c5d19d260615771b93186f2cc4431.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: remediation522c5d19d260615771b93186f2cc4431.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/body-shop/{audit}/remediation'
*/
const remediation522c5d19d260615771b93186f2cc4431Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation522c5d19d260615771b93186f2cc4431.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/body-shop/{audit}/remediation'
*/
remediation522c5d19d260615771b93186f2cc4431Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation522c5d19d260615771b93186f2cc4431.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/body-shop/{audit}/remediation'
*/
remediation522c5d19d260615771b93186f2cc4431Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation522c5d19d260615771b93186f2cc4431.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

remediation522c5d19d260615771b93186f2cc4431.form = remediation522c5d19d260615771b93186f2cc4431Form

export const remediation = {
    '/audits/osha/{audit}/remediation': remediation4a1236e49e13c58592c97bab56d4eb04,
    '/audits/body-shop/{audit}/remediation': remediation522c5d19d260615771b93186f2cc4431,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/remediation'
*/
const updateRemediation4a1236e49e13c58592c97bab56d4eb04 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateRemediation4a1236e49e13c58592c97bab56d4eb04.url(args, options),
    method: 'patch',
})

updateRemediation4a1236e49e13c58592c97bab56d4eb04.definition = {
    methods: ["patch"],
    url: '/audits/osha/{audit}/remediation',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/remediation'
*/
updateRemediation4a1236e49e13c58592c97bab56d4eb04.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return updateRemediation4a1236e49e13c58592c97bab56d4eb04.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/remediation'
*/
updateRemediation4a1236e49e13c58592c97bab56d4eb04.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateRemediation4a1236e49e13c58592c97bab56d4eb04.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/remediation'
*/
const updateRemediation4a1236e49e13c58592c97bab56d4eb04Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateRemediation4a1236e49e13c58592c97bab56d4eb04.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/remediation'
*/
updateRemediation4a1236e49e13c58592c97bab56d4eb04Form.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateRemediation4a1236e49e13c58592c97bab56d4eb04.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateRemediation4a1236e49e13c58592c97bab56d4eb04.form = updateRemediation4a1236e49e13c58592c97bab56d4eb04Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/body-shop/{audit}/remediation'
*/
const updateRemediation522c5d19d260615771b93186f2cc4431 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateRemediation522c5d19d260615771b93186f2cc4431.url(args, options),
    method: 'patch',
})

updateRemediation522c5d19d260615771b93186f2cc4431.definition = {
    methods: ["patch"],
    url: '/audits/body-shop/{audit}/remediation',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/body-shop/{audit}/remediation'
*/
updateRemediation522c5d19d260615771b93186f2cc4431.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return updateRemediation522c5d19d260615771b93186f2cc4431.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/body-shop/{audit}/remediation'
*/
updateRemediation522c5d19d260615771b93186f2cc4431.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateRemediation522c5d19d260615771b93186f2cc4431.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/body-shop/{audit}/remediation'
*/
const updateRemediation522c5d19d260615771b93186f2cc4431Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateRemediation522c5d19d260615771b93186f2cc4431.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/body-shop/{audit}/remediation'
*/
updateRemediation522c5d19d260615771b93186f2cc4431Form.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateRemediation522c5d19d260615771b93186f2cc4431.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateRemediation522c5d19d260615771b93186f2cc4431.form = updateRemediation522c5d19d260615771b93186f2cc4431Form

export const updateRemediation = {
    '/audits/osha/{audit}/remediation': updateRemediation4a1236e49e13c58592c97bab56d4eb04,
    '/audits/body-shop/{audit}/remediation': updateRemediation522c5d19d260615771b93186f2cc4431,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/osha/{audit}/download'
*/
const download7f27698048c5cb3dbee8bdad0b57cd48 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download7f27698048c5cb3dbee8bdad0b57cd48.url(args, options),
    method: 'get',
})

download7f27698048c5cb3dbee8bdad0b57cd48.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/osha/{audit}/download'
*/
download7f27698048c5cb3dbee8bdad0b57cd48.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return download7f27698048c5cb3dbee8bdad0b57cd48.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/osha/{audit}/download'
*/
download7f27698048c5cb3dbee8bdad0b57cd48.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download7f27698048c5cb3dbee8bdad0b57cd48.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/osha/{audit}/download'
*/
download7f27698048c5cb3dbee8bdad0b57cd48.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download7f27698048c5cb3dbee8bdad0b57cd48.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/osha/{audit}/download'
*/
const download7f27698048c5cb3dbee8bdad0b57cd48Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download7f27698048c5cb3dbee8bdad0b57cd48.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/osha/{audit}/download'
*/
download7f27698048c5cb3dbee8bdad0b57cd48Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download7f27698048c5cb3dbee8bdad0b57cd48.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/osha/{audit}/download'
*/
download7f27698048c5cb3dbee8bdad0b57cd48Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download7f27698048c5cb3dbee8bdad0b57cd48.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

download7f27698048c5cb3dbee8bdad0b57cd48.form = download7f27698048c5cb3dbee8bdad0b57cd48Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/body-shop/{audit}/download'
*/
const download9e8bdb796e5dabaaeb8e81b255879da4 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download9e8bdb796e5dabaaeb8e81b255879da4.url(args, options),
    method: 'get',
})

download9e8bdb796e5dabaaeb8e81b255879da4.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{audit}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/body-shop/{audit}/download'
*/
download9e8bdb796e5dabaaeb8e81b255879da4.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return download9e8bdb796e5dabaaeb8e81b255879da4.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/body-shop/{audit}/download'
*/
download9e8bdb796e5dabaaeb8e81b255879da4.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download9e8bdb796e5dabaaeb8e81b255879da4.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/body-shop/{audit}/download'
*/
download9e8bdb796e5dabaaeb8e81b255879da4.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download9e8bdb796e5dabaaeb8e81b255879da4.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/body-shop/{audit}/download'
*/
const download9e8bdb796e5dabaaeb8e81b255879da4Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download9e8bdb796e5dabaaeb8e81b255879da4.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/body-shop/{audit}/download'
*/
download9e8bdb796e5dabaaeb8e81b255879da4Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download9e8bdb796e5dabaaeb8e81b255879da4.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/body-shop/{audit}/download'
*/
download9e8bdb796e5dabaaeb8e81b255879da4Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download9e8bdb796e5dabaaeb8e81b255879da4.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

download9e8bdb796e5dabaaeb8e81b255879da4.form = download9e8bdb796e5dabaaeb8e81b255879da4Form

export const download = {
    '/audits/osha/{audit}/download': download7f27698048c5cb3dbee8bdad0b57cd48,
    '/audits/body-shop/{audit}/download': download9e8bdb796e5dabaaeb8e81b255879da4,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/osha/{audit}/remediation/download'
*/
const downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.url(args, options),
    method: 'get',
})

downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/remediation/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/osha/{audit}/remediation/download'
*/
const downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5.form = downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/body-shop/{audit}/remediation/download'
*/
const downloadRemediationf50870ddd1fc566f567ef34843959402 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadRemediationf50870ddd1fc566f567ef34843959402.url(args, options),
    method: 'get',
})

downloadRemediationf50870ddd1fc566f567ef34843959402.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{audit}/remediation/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/body-shop/{audit}/remediation/download'
*/
downloadRemediationf50870ddd1fc566f567ef34843959402.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return downloadRemediationf50870ddd1fc566f567ef34843959402.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/body-shop/{audit}/remediation/download'
*/
downloadRemediationf50870ddd1fc566f567ef34843959402.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadRemediationf50870ddd1fc566f567ef34843959402.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/body-shop/{audit}/remediation/download'
*/
downloadRemediationf50870ddd1fc566f567ef34843959402.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: downloadRemediationf50870ddd1fc566f567ef34843959402.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/body-shop/{audit}/remediation/download'
*/
const downloadRemediationf50870ddd1fc566f567ef34843959402Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediationf50870ddd1fc566f567ef34843959402.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/body-shop/{audit}/remediation/download'
*/
downloadRemediationf50870ddd1fc566f567ef34843959402Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediationf50870ddd1fc566f567ef34843959402.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:288
* @route '/audits/body-shop/{audit}/remediation/download'
*/
downloadRemediationf50870ddd1fc566f567ef34843959402Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediationf50870ddd1fc566f567ef34843959402.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

downloadRemediationf50870ddd1fc566f567ef34843959402.form = downloadRemediationf50870ddd1fc566f567ef34843959402Form

export const downloadRemediation = {
    '/audits/osha/{audit}/remediation/download': downloadRemediation537ec4ae6da27471f569e5c8c2e1c5e5,
    '/audits/body-shop/{audit}/remediation/download': downloadRemediationf50870ddd1fc566f567ef34843959402,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/osha/{audit}'
*/
const show7dc6084cd011454356fdc072c2fdd700 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'get',
})

show7dc6084cd011454356fdc072c2fdd700.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/osha/{audit}'
*/
show7dc6084cd011454356fdc072c2fdd700.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return show7dc6084cd011454356fdc072c2fdd700.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/osha/{audit}'
*/
show7dc6084cd011454356fdc072c2fdd700.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/osha/{audit}'
*/
show7dc6084cd011454356fdc072c2fdd700.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/osha/{audit}'
*/
const show7dc6084cd011454356fdc072c2fdd700Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/osha/{audit}'
*/
show7dc6084cd011454356fdc072c2fdd700Form.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show7dc6084cd011454356fdc072c2fdd700.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/osha/{audit}'
*/
show7dc6084cd011454356fdc072c2fdd700Form.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show7dc6084cd011454356fdc072c2fdd700.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show7dc6084cd011454356fdc072c2fdd700.form = show7dc6084cd011454356fdc072c2fdd700Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/body-shop/{audit}'
*/
const show5494c3ad34cb44680b965023d444ac2e = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'get',
})

show5494c3ad34cb44680b965023d444ac2e.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{audit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/body-shop/{audit}'
*/
show5494c3ad34cb44680b965023d444ac2e.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return show5494c3ad34cb44680b965023d444ac2e.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/body-shop/{audit}'
*/
show5494c3ad34cb44680b965023d444ac2e.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/body-shop/{audit}'
*/
show5494c3ad34cb44680b965023d444ac2e.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/body-shop/{audit}'
*/
const show5494c3ad34cb44680b965023d444ac2eForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/body-shop/{audit}'
*/
show5494c3ad34cb44680b965023d444ac2eForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show5494c3ad34cb44680b965023d444ac2e.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/body-shop/{audit}'
*/
show5494c3ad34cb44680b965023d444ac2eForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show5494c3ad34cb44680b965023d444ac2e.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show5494c3ad34cb44680b965023d444ac2e.form = show5494c3ad34cb44680b965023d444ac2eForm

export const show = {
    '/audits/osha/{audit}': show7dc6084cd011454356fdc072c2fdd700,
    '/audits/body-shop/{audit}': show5494c3ad34cb44680b965023d444ac2e,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/osha/{audit}/comments'
*/
const storeComment3f9ee4895ed272ee2167f18e888c33d6 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeComment3f9ee4895ed272ee2167f18e888c33d6.url(args, options),
    method: 'post',
})

storeComment3f9ee4895ed272ee2167f18e888c33d6.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/comments',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/osha/{audit}/comments'
*/
storeComment3f9ee4895ed272ee2167f18e888c33d6.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return storeComment3f9ee4895ed272ee2167f18e888c33d6.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/osha/{audit}/comments'
*/
storeComment3f9ee4895ed272ee2167f18e888c33d6.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeComment3f9ee4895ed272ee2167f18e888c33d6.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/osha/{audit}/comments'
*/
const storeComment3f9ee4895ed272ee2167f18e888c33d6Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeComment3f9ee4895ed272ee2167f18e888c33d6.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/osha/{audit}/comments'
*/
storeComment3f9ee4895ed272ee2167f18e888c33d6Form.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeComment3f9ee4895ed272ee2167f18e888c33d6.url(args, options),
    method: 'post',
})

storeComment3f9ee4895ed272ee2167f18e888c33d6.form = storeComment3f9ee4895ed272ee2167f18e888c33d6Form
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/body-shop/{audit}/comments'
*/
const storeComment0d59867aaf1c250865096e450a89fab6 = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeComment0d59867aaf1c250865096e450a89fab6.url(args, options),
    method: 'post',
})

storeComment0d59867aaf1c250865096e450a89fab6.definition = {
    methods: ["post"],
    url: '/audits/body-shop/{audit}/comments',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/body-shop/{audit}/comments'
*/
storeComment0d59867aaf1c250865096e450a89fab6.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { audit: args }
    }

    if (Array.isArray(args)) {
        args = {
            audit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
    }

    return storeComment0d59867aaf1c250865096e450a89fab6.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/body-shop/{audit}/comments'
*/
storeComment0d59867aaf1c250865096e450a89fab6.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeComment0d59867aaf1c250865096e450a89fab6.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/body-shop/{audit}/comments'
*/
const storeComment0d59867aaf1c250865096e450a89fab6Form = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeComment0d59867aaf1c250865096e450a89fab6.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::storeComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:327
* @route '/audits/body-shop/{audit}/comments'
*/
storeComment0d59867aaf1c250865096e450a89fab6Form.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeComment0d59867aaf1c250865096e450a89fab6.url(args, options),
    method: 'post',
})

storeComment0d59867aaf1c250865096e450a89fab6.form = storeComment0d59867aaf1c250865096e450a89fab6Form

export const storeComment = {
    '/audits/osha/{audit}/comments': storeComment3f9ee4895ed272ee2167f18e888c33d6,
    '/audits/body-shop/{audit}/comments': storeComment0d59867aaf1c250865096e450a89fab6,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/osha/{audit}/comments/{comment}'
*/
const updateComment04e7ff01fb0cf564620c218e290e8acd = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateComment04e7ff01fb0cf564620c218e290e8acd.url(args, options),
    method: 'patch',
})

updateComment04e7ff01fb0cf564620c218e290e8acd.definition = {
    methods: ["patch"],
    url: '/audits/osha/{audit}/comments/{comment}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/osha/{audit}/comments/{comment}'
*/
updateComment04e7ff01fb0cf564620c218e290e8acd.url = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            comment: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        comment: typeof args.comment === 'object'
        ? args.comment.id
        : args.comment,
    }

    return updateComment04e7ff01fb0cf564620c218e290e8acd.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/osha/{audit}/comments/{comment}'
*/
updateComment04e7ff01fb0cf564620c218e290e8acd.patch = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateComment04e7ff01fb0cf564620c218e290e8acd.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/osha/{audit}/comments/{comment}'
*/
const updateComment04e7ff01fb0cf564620c218e290e8acdForm = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateComment04e7ff01fb0cf564620c218e290e8acd.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/osha/{audit}/comments/{comment}'
*/
updateComment04e7ff01fb0cf564620c218e290e8acdForm.patch = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateComment04e7ff01fb0cf564620c218e290e8acd.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateComment04e7ff01fb0cf564620c218e290e8acd.form = updateComment04e7ff01fb0cf564620c218e290e8acdForm
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
const updateComment2a98ff86790445cdd85ced0924651008 = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateComment2a98ff86790445cdd85ced0924651008.url(args, options),
    method: 'patch',
})

updateComment2a98ff86790445cdd85ced0924651008.definition = {
    methods: ["patch"],
    url: '/audits/body-shop/{audit}/comments/{comment}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
updateComment2a98ff86790445cdd85ced0924651008.url = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            comment: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        comment: typeof args.comment === 'object'
        ? args.comment.id
        : args.comment,
    }

    return updateComment2a98ff86790445cdd85ced0924651008.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
updateComment2a98ff86790445cdd85ced0924651008.patch = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateComment2a98ff86790445cdd85ced0924651008.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
const updateComment2a98ff86790445cdd85ced0924651008Form = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateComment2a98ff86790445cdd85ced0924651008.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:344
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
updateComment2a98ff86790445cdd85ced0924651008Form.patch = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateComment2a98ff86790445cdd85ced0924651008.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateComment2a98ff86790445cdd85ced0924651008.form = updateComment2a98ff86790445cdd85ced0924651008Form

export const updateComment = {
    '/audits/osha/{audit}/comments/{comment}': updateComment04e7ff01fb0cf564620c218e290e8acd,
    '/audits/body-shop/{audit}/comments/{comment}': updateComment2a98ff86790445cdd85ced0924651008,
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/osha/{audit}/comments/{comment}'
*/
const destroyComment04e7ff01fb0cf564620c218e290e8acd = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyComment04e7ff01fb0cf564620c218e290e8acd.url(args, options),
    method: 'delete',
})

destroyComment04e7ff01fb0cf564620c218e290e8acd.definition = {
    methods: ["delete"],
    url: '/audits/osha/{audit}/comments/{comment}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/osha/{audit}/comments/{comment}'
*/
destroyComment04e7ff01fb0cf564620c218e290e8acd.url = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            comment: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        comment: typeof args.comment === 'object'
        ? args.comment.id
        : args.comment,
    }

    return destroyComment04e7ff01fb0cf564620c218e290e8acd.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/osha/{audit}/comments/{comment}'
*/
destroyComment04e7ff01fb0cf564620c218e290e8acd.delete = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyComment04e7ff01fb0cf564620c218e290e8acd.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/osha/{audit}/comments/{comment}'
*/
const destroyComment04e7ff01fb0cf564620c218e290e8acdForm = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroyComment04e7ff01fb0cf564620c218e290e8acd.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/osha/{audit}/comments/{comment}'
*/
destroyComment04e7ff01fb0cf564620c218e290e8acdForm.delete = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroyComment04e7ff01fb0cf564620c218e290e8acd.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroyComment04e7ff01fb0cf564620c218e290e8acd.form = destroyComment04e7ff01fb0cf564620c218e290e8acdForm
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
const destroyComment2a98ff86790445cdd85ced0924651008 = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyComment2a98ff86790445cdd85ced0924651008.url(args, options),
    method: 'delete',
})

destroyComment2a98ff86790445cdd85ced0924651008.definition = {
    methods: ["delete"],
    url: '/audits/body-shop/{audit}/comments/{comment}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
destroyComment2a98ff86790445cdd85ced0924651008.url = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            audit: args[0],
            comment: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        audit: args.audit,
        comment: typeof args.comment === 'object'
        ? args.comment.id
        : args.comment,
    }

    return destroyComment2a98ff86790445cdd85ced0924651008.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
destroyComment2a98ff86790445cdd85ced0924651008.delete = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyComment2a98ff86790445cdd85ced0924651008.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
const destroyComment2a98ff86790445cdd85ced0924651008Form = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroyComment2a98ff86790445cdd85ced0924651008.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroyComment
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:360
* @route '/audits/body-shop/{audit}/comments/{comment}'
*/
destroyComment2a98ff86790445cdd85ced0924651008Form.delete = (args: { audit: string | number, comment: string | number | { id: string | number } } | [audit: string | number, comment: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroyComment2a98ff86790445cdd85ced0924651008.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroyComment2a98ff86790445cdd85ced0924651008.form = destroyComment2a98ff86790445cdd85ced0924651008Form

export const destroyComment = {
    '/audits/osha/{audit}/comments/{comment}': destroyComment04e7ff01fb0cf564620c218e290e8acd,
    '/audits/body-shop/{audit}/comments/{comment}': destroyComment2a98ff86790445cdd85ced0924651008,
}

const ViolationAuditController = { create, edit, update, destroy, updateGrade, complete, reopen, addViolation, deleteViolation, deleteViolationPhoto, generate, generateRemediation, searchStatements, index, remediation, updateRemediation, download, downloadRemediation, show, storeComment, updateComment, destroyComment }

export default ViolationAuditController