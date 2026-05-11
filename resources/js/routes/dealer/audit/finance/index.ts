import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
import violations from './violations'
import remediation065e42 from './remediation'
import comments from './comments'
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/finance/create/{store}'
*/
export const create = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/audits/finance/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/finance/create/{store}'
*/
create.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return create.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/finance/create/{store}'
*/
create.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/finance/create/{store}'
*/
create.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/finance/create/{store}'
*/
const createForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/finance/create/{store}'
*/
createForm.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:163
* @route '/audits/finance/create/{store}'
*/
createForm.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/finance/{audit}/edit'
*/
export const edit = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{audit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/finance/{audit}/edit'
*/
edit.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/finance/{audit}/edit'
*/
edit.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/finance/{audit}/edit'
*/
edit.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/finance/{audit}/edit'
*/
const editForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/finance/{audit}/edit'
*/
editForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:118
* @route '/audits/finance/{audit}/edit'
*/
editForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/finance/{audit}'
*/
export const update = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/audits/finance/{audit}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/finance/{audit}'
*/
update.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/finance/{audit}'
*/
update.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:135
* @route '/audits/finance/{audit}'
*/
const updateForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
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
* @route '/audits/finance/{audit}'
*/
updateForm.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/finance/{audit}'
*/
export const destroy = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/audits/finance/{audit}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/finance/{audit}'
*/
destroy.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/finance/{audit}'
*/
destroy.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:149
* @route '/audits/finance/{audit}'
*/
const destroyForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
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
* @route '/audits/finance/{audit}'
*/
destroyForm.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::grade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/finance/{audit}/grade'
*/
export const grade = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: grade.url(args, options),
    method: 'patch',
})

grade.definition = {
    methods: ["patch"],
    url: '/audits/finance/{audit}/grade',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::grade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/finance/{audit}/grade'
*/
grade.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return grade.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::grade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/finance/{audit}/grade'
*/
grade.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: grade.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::grade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/finance/{audit}/grade'
*/
const gradeForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: grade.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::grade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:402
* @route '/audits/finance/{audit}/grade'
*/
gradeForm.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: grade.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

grade.form = gradeForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/finance/{audit}/complete'
*/
export const complete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: complete.url(args, options),
    method: 'post',
})

complete.definition = {
    methods: ["post"],
    url: '/audits/finance/{audit}/complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/finance/{audit}/complete'
*/
complete.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return complete.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/finance/{audit}/complete'
*/
complete.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: complete.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/finance/{audit}/complete'
*/
const completeForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: complete.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::complete
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:376
* @route '/audits/finance/{audit}/complete'
*/
completeForm.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: complete.url(args, options),
    method: 'post',
})

complete.form = completeForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/finance/{audit}/complete'
*/
export const reopen = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: reopen.url(args, options),
    method: 'delete',
})

reopen.definition = {
    methods: ["delete"],
    url: '/audits/finance/{audit}/complete',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/finance/{audit}/complete'
*/
reopen.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return reopen.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/finance/{audit}/complete'
*/
reopen.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: reopen.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::reopen
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:389
* @route '/audits/finance/{audit}/complete'
*/
const reopenForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: reopen.url(args, {
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
* @route '/audits/finance/{audit}/complete'
*/
reopenForm.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: reopen.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

reopen.form = reopenForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/finance/{audit}/generate'
*/
export const generate = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

generate.definition = {
    methods: ["post"],
    url: '/audits/finance/{audit}/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/finance/{audit}/generate'
*/
generate.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return generate.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/finance/{audit}/generate'
*/
generate.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/finance/{audit}/generate'
*/
const generateForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:301
* @route '/audits/finance/{audit}/generate'
*/
generateForm.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generate.url(args, options),
    method: 'post',
})

generate.form = generateForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/finance'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/audits/finance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/finance'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/finance'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/finance'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/finance'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/finance'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:55
* @route '/audits/finance'
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/finance/{audit}/remediation'
*/
export const remediation = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation.url(args, options),
    method: 'get',
})

remediation.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{audit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/finance/{audit}/remediation'
*/
remediation.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return remediation.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/finance/{audit}/remediation'
*/
remediation.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/finance/{audit}/remediation'
*/
remediation.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: remediation.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/finance/{audit}/remediation'
*/
const remediationForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/finance/{audit}/remediation'
*/
remediationForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:177
* @route '/audits/finance/{audit}/remediation'
*/
remediationForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

remediation.form = remediationForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/finance/{audit}/download'
*/
export const download = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{audit}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/finance/{audit}/download'
*/
download.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return download.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/finance/{audit}/download'
*/
download.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/finance/{audit}/download'
*/
download.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/finance/{audit}/download'
*/
const downloadForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/finance/{audit}/download'
*/
downloadForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:275
* @route '/audits/finance/{audit}/download'
*/
downloadForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

download.form = downloadForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/finance/{audit}'
*/
export const show = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{audit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/finance/{audit}'
*/
show.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/finance/{audit}'
*/
show.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/finance/{audit}'
*/
show.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/finance/{audit}'
*/
const showForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/finance/{audit}'
*/
showForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:99
* @route '/audits/finance/{audit}'
*/
showForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const finance = {
    create: Object.assign(create, create),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
    grade: Object.assign(grade, grade),
    complete: Object.assign(complete, complete),
    reopen: Object.assign(reopen, reopen),
    violations: Object.assign(violations, violations),
    generate: Object.assign(generate, generate),
    remediation: Object.assign(remediation, remediation065e42),
    index: Object.assign(index, index),
    download: Object.assign(download, download),
    show: Object.assign(show, show),
    comments: Object.assign(comments, comments),
}

export default finance