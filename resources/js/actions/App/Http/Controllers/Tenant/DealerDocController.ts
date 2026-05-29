import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\DealerDocController::index
* @see app/Http/Controllers/Tenant/DealerDocController.php:26
* @route '/documents'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/documents',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::index
* @see app/Http/Controllers/Tenant/DealerDocController.php:26
* @route '/documents'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::index
* @see app/Http/Controllers/Tenant/DealerDocController.php:26
* @route '/documents'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::index
* @see app/Http/Controllers/Tenant/DealerDocController.php:26
* @route '/documents'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::store
* @see app/Http/Controllers/Tenant/DealerDocController.php:45
* @route '/documents'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/documents',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::store
* @see app/Http/Controllers/Tenant/DealerDocController.php:45
* @route '/documents'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::store
* @see app/Http/Controllers/Tenant/DealerDocController.php:45
* @route '/documents'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:75
* @route '/documents/{dealerDoc}/download'
*/
export const download = (args: { dealerDoc: string | number | { id: string | number } } | [dealerDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/documents/{dealerDoc}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:75
* @route '/documents/{dealerDoc}/download'
*/
download.url = (args: { dealerDoc: string | number | { id: string | number } } | [dealerDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealerDoc: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { dealerDoc: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            dealerDoc: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealerDoc: typeof args.dealerDoc === 'object'
        ? args.dealerDoc.id
        : args.dealerDoc,
    }

    return download.definition.url
            .replace('{dealerDoc}', parsedArgs.dealerDoc.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:75
* @route '/documents/{dealerDoc}/download'
*/
download.get = (args: { dealerDoc: string | number | { id: string | number } } | [dealerDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:75
* @route '/documents/{dealerDoc}/download'
*/
download.head = (args: { dealerDoc: string | number | { id: string | number } } | [dealerDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::downloadShared
* @see app/Http/Controllers/Tenant/DealerDocController.php:88
* @route '/documents/shared/{sharedDocument}/download'
*/
export const downloadShared = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadShared.url(args, options),
    method: 'get',
})

downloadShared.definition = {
    methods: ["get","head"],
    url: '/documents/shared/{sharedDocument}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::downloadShared
* @see app/Http/Controllers/Tenant/DealerDocController.php:88
* @route '/documents/shared/{sharedDocument}/download'
*/
downloadShared.url = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sharedDocument: args }
    }

    if (Array.isArray(args)) {
        args = {
            sharedDocument: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        sharedDocument: args.sharedDocument,
    }

    return downloadShared.definition.url
            .replace('{sharedDocument}', parsedArgs.sharedDocument.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::downloadShared
* @see app/Http/Controllers/Tenant/DealerDocController.php:88
* @route '/documents/shared/{sharedDocument}/download'
*/
downloadShared.get = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadShared.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::downloadShared
* @see app/Http/Controllers/Tenant/DealerDocController.php:88
* @route '/documents/shared/{sharedDocument}/download'
*/
downloadShared.head = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: downloadShared.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::destroy
* @see app/Http/Controllers/Tenant/DealerDocController.php:60
* @route '/documents/{dealerDoc}'
*/
export const destroy = (args: { dealerDoc: string | number | { id: string | number } } | [dealerDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/documents/{dealerDoc}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::destroy
* @see app/Http/Controllers/Tenant/DealerDocController.php:60
* @route '/documents/{dealerDoc}'
*/
destroy.url = (args: { dealerDoc: string | number | { id: string | number } } | [dealerDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealerDoc: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { dealerDoc: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            dealerDoc: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealerDoc: typeof args.dealerDoc === 'object'
        ? args.dealerDoc.id
        : args.dealerDoc,
    }

    return destroy.definition.url
            .replace('{dealerDoc}', parsedArgs.dealerDoc.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::destroy
* @see app/Http/Controllers/Tenant/DealerDocController.php:60
* @route '/documents/{dealerDoc}'
*/
destroy.delete = (args: { dealerDoc: string | number | { id: string | number } } | [dealerDoc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const DealerDocController = { index, store, download, downloadShared, destroy }

export default DealerDocController