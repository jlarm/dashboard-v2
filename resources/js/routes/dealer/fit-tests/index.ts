import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::index
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:28
* @route '/fit-tests'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/fit-tests',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::index
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:28
* @route '/fit-tests'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::index
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:28
* @route '/fit-tests'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::index
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:28
* @route '/fit-tests'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::store
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:45
* @route '/fit-tests'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/fit-tests',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::store
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:45
* @route '/fit-tests'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::store
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:45
* @route '/fit-tests'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::download
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:80
* @route '/fit-tests/{fitTestDoc}/download'
*/
export const download = (args: { fitTestDoc: string | number | { id: string | number } } | [fitTestDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/fit-tests/{fitTestDoc}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::download
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:80
* @route '/fit-tests/{fitTestDoc}/download'
*/
download.url = (args: { fitTestDoc: string | number | { id: string | number } } | [fitTestDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { fitTestDoc: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { fitTestDoc: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            fitTestDoc: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        fitTestDoc: typeof args.fitTestDoc === 'object'
        ? args.fitTestDoc.id
        : args.fitTestDoc,
    }

    return download.definition.url
            .replace('{fitTestDoc}', parsedArgs.fitTestDoc.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::download
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:80
* @route '/fit-tests/{fitTestDoc}/download'
*/
download.get = (args: { fitTestDoc: string | number | { id: string | number } } | [fitTestDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::download
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:80
* @route '/fit-tests/{fitTestDoc}/download'
*/
download.head = (args: { fitTestDoc: string | number | { id: string | number } } | [fitTestDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::destroy
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:62
* @route '/fit-tests/{fitTestDoc}'
*/
export const destroy = (args: { fitTestDoc: string | number | { id: string | number } } | [fitTestDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/fit-tests/{fitTestDoc}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::destroy
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:62
* @route '/fit-tests/{fitTestDoc}'
*/
destroy.url = (args: { fitTestDoc: string | number | { id: string | number } } | [fitTestDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { fitTestDoc: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { fitTestDoc: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            fitTestDoc: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        fitTestDoc: typeof args.fitTestDoc === 'object'
        ? args.fitTestDoc.id
        : args.fitTestDoc,
    }

    return destroy.definition.url
            .replace('{fitTestDoc}', parsedArgs.fitTestDoc.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\FitTestController::destroy
* @see app/Http/Controllers/Tenant/Audit/FitTestController.php:62
* @route '/fit-tests/{fitTestDoc}'
*/
destroy.delete = (args: { fitTestDoc: string | number | { id: string | number } } | [fitTestDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const fitTests = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    download: Object.assign(download, download),
    destroy: Object.assign(destroy, destroy),
}

export default fitTests