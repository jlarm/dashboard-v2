import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
export const create = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
create.url = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: args.store,
    }

    return create.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
create.get = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
create.head = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
const createForm = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
createForm.get = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\BodyShopCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/BodyShopCreateController.php:14
* @route '/audits/body-shop/create/{store}'
*/
createForm.head = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Edit.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/edit'
*/
export const edit = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{bodyShopViolationAudit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Edit.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/edit'
*/
edit.url = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { bodyShopViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { bodyShopViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            bodyShopViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        bodyShopViolationAudit: typeof args.bodyShopViolationAudit === 'object'
        ? args.bodyShopViolationAudit.uuid
        : args.bodyShopViolationAudit,
    }

    return edit.definition.url
            .replace('{bodyShopViolationAudit}', parsedArgs.bodyShopViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Edit.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/edit'
*/
edit.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Edit.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/edit'
*/
edit.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Edit.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/edit'
*/
const editForm = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Edit.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/edit'
*/
editForm.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Edit.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/edit'
*/
editForm.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Index.php:7
* @route '/audits/body-shop'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Index.php:7
* @route '/audits/body-shop'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Index.php:7
* @route '/audits/body-shop'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Index.php:7
* @route '/audits/body-shop'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Index.php:7
* @route '/audits/body-shop'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Index.php:7
* @route '/audits/body-shop'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Index.php:7
* @route '/audits/body-shop'
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
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
export const remediation = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation.url(args, options),
    method: 'get',
})

remediation.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{bodyShopViolationAudit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
remediation.url = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { bodyShopViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { bodyShopViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            bodyShopViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        bodyShopViolationAudit: typeof args.bodyShopViolationAudit === 'object'
        ? args.bodyShopViolationAudit.uuid
        : args.bodyShopViolationAudit,
    }

    return remediation.definition.url
            .replace('{bodyShopViolationAudit}', parsedArgs.bodyShopViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
remediation.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
remediation.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: remediation.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
const remediationForm = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
remediationForm.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}/remediation'
*/
remediationForm.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
export const show = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{bodyShopViolationAudit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
show.url = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { bodyShopViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { bodyShopViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            bodyShopViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        bodyShopViolationAudit: typeof args.bodyShopViolationAudit === 'object'
        ? args.bodyShopViolationAudit.uuid
        : args.bodyShopViolationAudit,
    }

    return show.definition.url
            .replace('{bodyShopViolationAudit}', parsedArgs.bodyShopViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
show.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
show.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
const showForm = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
showForm.get = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\BodyShop\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/BodyShop/Single.php:7
* @route '/audits/body-shop/{bodyShopViolationAudit}'
*/
showForm.head = (args: { bodyShopViolationAudit: string | number | { uuid: string | number } } | [bodyShopViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const bodyShop = {
    create: Object.assign(create, create),
    edit: Object.assign(edit, edit),
    index: Object.assign(index, index),
    remediation: Object.assign(remediation, remediation),
    show: Object.assign(show, show),
}

export default bodyShop