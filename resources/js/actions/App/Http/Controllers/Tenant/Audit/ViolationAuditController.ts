import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:148
* @route '/audits/osha/create/{store}'
*/
export const create = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/audits/osha/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:148
* @route '/audits/osha/create/{store}'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:148
* @route '/audits/osha/create/{store}'
*/
create.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:148
* @route '/audits/osha/create/{store}'
*/
create.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:148
* @route '/audits/osha/create/{store}'
*/
const createForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:148
* @route '/audits/osha/create/{store}'
*/
createForm.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::create
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:148
* @route '/audits/osha/create/{store}'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:103
* @route '/audits/osha/{audit}/edit'
*/
export const edit = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:103
* @route '/audits/osha/{audit}/edit'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:103
* @route '/audits/osha/{audit}/edit'
*/
edit.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:103
* @route '/audits/osha/{audit}/edit'
*/
edit.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:103
* @route '/audits/osha/{audit}/edit'
*/
const editForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:103
* @route '/audits/osha/{audit}/edit'
*/
editForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::edit
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:103
* @route '/audits/osha/{audit}/edit'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:120
* @route '/audits/osha/{audit}'
*/
export const update = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/audits/osha/{audit}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:120
* @route '/audits/osha/{audit}'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:120
* @route '/audits/osha/{audit}'
*/
update.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::update
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:120
* @route '/audits/osha/{audit}'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:120
* @route '/audits/osha/{audit}'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:134
* @route '/audits/osha/{audit}'
*/
export const destroy = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/audits/osha/{audit}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:134
* @route '/audits/osha/{audit}'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:134
* @route '/audits/osha/{audit}'
*/
destroy.delete = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:134
* @route '/audits/osha/{audit}'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:134
* @route '/audits/osha/{audit}'
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:306
* @route '/audits/osha/{audit}/grade'
*/
export const updateGrade = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateGrade.url(args, options),
    method: 'patch',
})

updateGrade.definition = {
    methods: ["patch"],
    url: '/audits/osha/{audit}/grade',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:306
* @route '/audits/osha/{audit}/grade'
*/
updateGrade.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return updateGrade.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:306
* @route '/audits/osha/{audit}/grade'
*/
updateGrade.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateGrade.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:306
* @route '/audits/osha/{audit}/grade'
*/
const updateGradeForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateGrade.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateGrade
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:306
* @route '/audits/osha/{audit}/grade'
*/
updateGradeForm.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateGrade.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateGrade.form = updateGradeForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/violations'
*/
export const addViolation = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: addViolation.url(args, options),
    method: 'post',
})

addViolation.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/violations',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/violations'
*/
addViolation.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return addViolation.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/violations'
*/
addViolation.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: addViolation.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/violations'
*/
const addViolationForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: addViolation.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::addViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:196
* @route '/audits/osha/{audit}/violations'
*/
addViolationForm.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: addViolation.url(args, options),
    method: 'post',
})

addViolation.form = addViolationForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:210
* @route '/audits/osha/{audit}/violations/{violation}'
*/
export const deleteViolation = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolation.url(args, options),
    method: 'delete',
})

deleteViolation.definition = {
    methods: ["delete"],
    url: '/audits/osha/{audit}/violations/{violation}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:210
* @route '/audits/osha/{audit}/violations/{violation}'
*/
deleteViolation.url = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
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

    return deleteViolation.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{violation}', parsedArgs.violation.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:210
* @route '/audits/osha/{audit}/violations/{violation}'
*/
deleteViolation.delete = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolation.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:210
* @route '/audits/osha/{audit}/violations/{violation}'
*/
const deleteViolationForm = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolation.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:210
* @route '/audits/osha/{audit}/violations/{violation}'
*/
deleteViolationForm.delete = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolation.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

deleteViolation.form = deleteViolationForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:226
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
export const deleteViolationPhoto = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolationPhoto.url(args, options),
    method: 'delete',
})

deleteViolationPhoto.definition = {
    methods: ["delete"],
    url: '/audits/osha/{audit}/violations/{violation}/photos/{photoId}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:226
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhoto.url = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions) => {
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

    return deleteViolationPhoto.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{violation}', parsedArgs.violation.toString())
            .replace('{photoId}', parsedArgs.photoId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:226
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhoto.delete = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteViolationPhoto.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:226
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
const deleteViolationPhotoForm = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolationPhoto.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::deleteViolationPhoto
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:226
* @route '/audits/osha/{audit}/violations/{violation}/photos/{photoId}'
*/
deleteViolationPhotoForm.delete = (args: { audit: string | number, violation: string | number | { id: string | number }, photoId: string | number } | [audit: string | number, violation: string | number | { id: string | number }, photoId: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: deleteViolationPhoto.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

deleteViolationPhoto.form = deleteViolationPhotoForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:280
* @route '/audits/osha/{audit}/generate'
*/
export const generate = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

generate.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:280
* @route '/audits/osha/{audit}/generate'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:280
* @route '/audits/osha/{audit}/generate'
*/
generate.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:280
* @route '/audits/osha/{audit}/generate'
*/
const generateForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generate
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:280
* @route '/audits/osha/{audit}/generate'
*/
generateForm.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generate.url(args, options),
    method: 'post',
})

generate.form = generateForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:293
* @route '/audits/osha/{audit}/remediation/generate'
*/
export const generateRemediation = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateRemediation.url(args, options),
    method: 'post',
})

generateRemediation.definition = {
    methods: ["post"],
    url: '/audits/osha/{audit}/remediation/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:293
* @route '/audits/osha/{audit}/remediation/generate'
*/
generateRemediation.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return generateRemediation.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:293
* @route '/audits/osha/{audit}/remediation/generate'
*/
generateRemediation.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generateRemediation.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:293
* @route '/audits/osha/{audit}/remediation/generate'
*/
const generateRemediationForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateRemediation.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::generateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:293
* @route '/audits/osha/{audit}/remediation/generate'
*/
generateRemediationForm.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: generateRemediation.url(args, options),
    method: 'post',
})

generateRemediation.form = generateRemediationForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/search'
*/
export const searchStatements = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchStatements.url(args, options),
    method: 'get',
})

searchStatements.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/violations/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatements.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return searchStatements.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatements.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchStatements.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatements.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: searchStatements.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/search'
*/
const searchStatementsForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatements.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatementsForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatements.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::searchStatements
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:243
* @route '/audits/osha/{audit}/violations/search'
*/
searchStatementsForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchStatements.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

searchStatements.form = searchStatementsForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:47
* @route '/audits/osha'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/audits/osha',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:47
* @route '/audits/osha'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:47
* @route '/audits/osha'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:47
* @route '/audits/osha'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:47
* @route '/audits/osha'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:47
* @route '/audits/osha'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::index
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:47
* @route '/audits/osha'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:162
* @route '/audits/osha/{audit}/remediation'
*/
export const remediation = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation.url(args, options),
    method: 'get',
})

remediation.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:162
* @route '/audits/osha/{audit}/remediation'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:162
* @route '/audits/osha/{audit}/remediation'
*/
remediation.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:162
* @route '/audits/osha/{audit}/remediation'
*/
remediation.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: remediation.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:162
* @route '/audits/osha/{audit}/remediation'
*/
const remediationForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:162
* @route '/audits/osha/{audit}/remediation'
*/
remediationForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::remediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:162
* @route '/audits/osha/{audit}/remediation'
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:179
* @route '/audits/osha/{audit}/remediation'
*/
export const updateRemediation = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateRemediation.url(args, options),
    method: 'patch',
})

updateRemediation.definition = {
    methods: ["patch"],
    url: '/audits/osha/{audit}/remediation',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:179
* @route '/audits/osha/{audit}/remediation'
*/
updateRemediation.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return updateRemediation.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:179
* @route '/audits/osha/{audit}/remediation'
*/
updateRemediation.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateRemediation.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:179
* @route '/audits/osha/{audit}/remediation'
*/
const updateRemediationForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateRemediation.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::updateRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:179
* @route '/audits/osha/{audit}/remediation'
*/
updateRemediationForm.patch = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateRemediation.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateRemediation.form = updateRemediationForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:258
* @route '/audits/osha/{audit}/download'
*/
export const download = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:258
* @route '/audits/osha/{audit}/download'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:258
* @route '/audits/osha/{audit}/download'
*/
download.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:258
* @route '/audits/osha/{audit}/download'
*/
download.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:258
* @route '/audits/osha/{audit}/download'
*/
const downloadForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:258
* @route '/audits/osha/{audit}/download'
*/
downloadForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::download
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:258
* @route '/audits/osha/{audit}/download'
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:269
* @route '/audits/osha/{audit}/remediation/download'
*/
export const downloadRemediation = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadRemediation.url(args, options),
    method: 'get',
})

downloadRemediation.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}/remediation/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:269
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediation.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return downloadRemediation.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:269
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediation.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadRemediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:269
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediation.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: downloadRemediation.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:269
* @route '/audits/osha/{audit}/remediation/download'
*/
const downloadRemediationForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:269
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediationForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::downloadRemediation
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:269
* @route '/audits/osha/{audit}/remediation/download'
*/
downloadRemediationForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadRemediation.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

downloadRemediation.form = downloadRemediationForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:86
* @route '/audits/osha/{audit}'
*/
export const show = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/osha/{audit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:86
* @route '/audits/osha/{audit}'
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:86
* @route '/audits/osha/{audit}'
*/
show.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:86
* @route '/audits/osha/{audit}'
*/
show.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:86
* @route '/audits/osha/{audit}'
*/
const showForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:86
* @route '/audits/osha/{audit}'
*/
showForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::show
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:86
* @route '/audits/osha/{audit}'
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

const ViolationAuditController = { create, edit, update, destroy, updateGrade, addViolation, deleteViolation, deleteViolationPhoto, generate, generateRemediation, searchStatements, index, remediation, updateRemediation, download, downloadRemediation, show }

export default ViolationAuditController