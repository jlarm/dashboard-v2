import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
import photos from './photos'
/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::store
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:217
* @route '/audits/body-shop/{audit}/violations'
*/
export const store = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/audits/body-shop/{audit}/violations',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::store
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:217
* @route '/audits/body-shop/{audit}/violations'
*/
store.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::store
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:217
* @route '/audits/body-shop/{audit}/violations'
*/
store.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::store
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:217
* @route '/audits/body-shop/{audit}/violations'
*/
const storeForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::store
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:217
* @route '/audits/body-shop/{audit}/violations'
*/
storeForm.post = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:231
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
export const destroy = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/audits/body-shop/{audit}/violations/{violation}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:231
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
destroy.url = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace('{violation}', parsedArgs.violation.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:231
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
destroy.delete = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::destroy
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:231
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
const destroyForm = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:231
* @route '/audits/body-shop/{audit}/violations/{violation}'
*/
destroyForm.delete = (args: { audit: string | number, violation: string | number | { id: string | number } } | [audit: string | number, violation: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::search
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:264
* @route '/audits/body-shop/{audit}/violations/search'
*/
export const search = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(args, options),
    method: 'get',
})

search.definition = {
    methods: ["get","head"],
    url: '/audits/body-shop/{audit}/violations/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::search
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:264
* @route '/audits/body-shop/{audit}/violations/search'
*/
search.url = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return search.definition.url
            .replace('{audit}', parsedArgs.audit.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::search
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:264
* @route '/audits/body-shop/{audit}/violations/search'
*/
search.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::search
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:264
* @route '/audits/body-shop/{audit}/violations/search'
*/
search.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: search.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::search
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:264
* @route '/audits/body-shop/{audit}/violations/search'
*/
const searchForm = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: search.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::search
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:264
* @route '/audits/body-shop/{audit}/violations/search'
*/
searchForm.get = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: search.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\ViolationAuditController::search
* @see app/Http/Controllers/Tenant/Audit/ViolationAuditController.php:264
* @route '/audits/body-shop/{audit}/violations/search'
*/
searchForm.head = (args: { audit: string | number } | [audit: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: search.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

search.form = searchForm

const violations = {
    store: Object.assign(store, store),
    destroy: Object.assign(destroy, destroy),
    photos: Object.assign(photos, photos),
    search: Object.assign(search, search),
}

export default violations