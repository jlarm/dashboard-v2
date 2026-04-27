import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Audit\FinanceCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/FinanceCreateController.php:14
* @route '/audits/finance/create/{store}'
*/
export const create = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/audits/finance/create/{store}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\Audit\FinanceCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/FinanceCreateController.php:14
* @route '/audits/finance/create/{store}'
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
* @see \App\Http\Controllers\Dealer\Audit\FinanceCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/FinanceCreateController.php:14
* @route '/audits/finance/create/{store}'
*/
create.get = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\Audit\FinanceCreateController::__invoke
* @see app/Http/Controllers/Dealer/Audit/FinanceCreateController.php:14
* @route '/audits/finance/create/{store}'
*/
create.head = (args: { store: string | number } | [store: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Edit.php:7
* @route '/audits/finance/{glbaViolationAudit}/edit'
*/
export const edit = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{glbaViolationAudit}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Edit.php:7
* @route '/audits/finance/{glbaViolationAudit}/edit'
*/
edit.url = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { glbaViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { glbaViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            glbaViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        glbaViolationAudit: typeof args.glbaViolationAudit === 'object'
        ? args.glbaViolationAudit.uuid
        : args.glbaViolationAudit,
    }

    return edit.definition.url
            .replace('{glbaViolationAudit}', parsedArgs.glbaViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Edit.php:7
* @route '/audits/finance/{glbaViolationAudit}/edit'
*/
edit.get = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Edit::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Edit.php:7
* @route '/audits/finance/{glbaViolationAudit}/edit'
*/
edit.head = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
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
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Index::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Index.php:7
* @route '/audits/finance'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php:7
* @route '/audits/finance/{glbaViolationAudit}/remediation'
*/
export const remediation = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation.url(args, options),
    method: 'get',
})

remediation.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{glbaViolationAudit}/remediation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php:7
* @route '/audits/finance/{glbaViolationAudit}/remediation'
*/
remediation.url = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { glbaViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { glbaViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            glbaViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        glbaViolationAudit: typeof args.glbaViolationAudit === 'object'
        ? args.glbaViolationAudit.uuid
        : args.glbaViolationAudit,
    }

    return remediation.definition.url
            .replace('{glbaViolationAudit}', parsedArgs.glbaViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php:7
* @route '/audits/finance/{glbaViolationAudit}/remediation'
*/
remediation.get = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: remediation.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\RemediationForm::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php:7
* @route '/audits/finance/{glbaViolationAudit}/remediation'
*/
remediation.head = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: remediation.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Single.php:7
* @route '/audits/finance/{glbaViolationAudit}'
*/
export const show = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/finance/{glbaViolationAudit}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Single.php:7
* @route '/audits/finance/{glbaViolationAudit}'
*/
show.url = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { glbaViolationAudit: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { glbaViolationAudit: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            glbaViolationAudit: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        glbaViolationAudit: typeof args.glbaViolationAudit === 'object'
        ? args.glbaViolationAudit.uuid
        : args.glbaViolationAudit,
    }

    return show.definition.url
            .replace('{glbaViolationAudit}', parsedArgs.glbaViolationAudit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Single.php:7
* @route '/audits/finance/{glbaViolationAudit}'
*/
show.get = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Livewire\Dealer\Audit\Finance\Single::__invoke
* @see app/Http/Livewire/Dealer/Audit/Finance/Single.php:7
* @route '/audits/finance/{glbaViolationAudit}'
*/
show.head = (args: { glbaViolationAudit: string | number | { uuid: string | number } } | [glbaViolationAudit: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const finance = {
    create: Object.assign(create, create),
    edit: Object.assign(edit, edit),
    index: Object.assign(index, index),
    remediation: Object.assign(remediation, remediation),
    show: Object.assign(show, show),
}

export default finance