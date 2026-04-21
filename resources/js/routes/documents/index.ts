import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:25
* @route '//dashboard.test/documents'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/documents',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:25
* @route '//dashboard.test/documents'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:25
* @route '//dashboard.test/documents'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:25
* @route '//dashboard.test/documents'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::store
* @see app/Http/Controllers/Central/DocumentController.php:48
* @route '//dashboard.test/documents'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/documents',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\DocumentController::store
* @see app/Http/Controllers/Central/DocumentController.php:48
* @route '//dashboard.test/documents'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\DocumentController::store
* @see app/Http/Controllers/Central/DocumentController.php:48
* @route '//dashboard.test/documents'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:63
* @route '//dashboard.test/documents/{document}/download'
*/
export const download = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/documents/{document}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:63
* @route '//dashboard.test/documents/{document}/download'
*/
download.url = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { document: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { document: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            document: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        document: typeof args.document === 'object'
        ? args.document.id
        : args.document,
    }

    return download.definition.url
            .replace('{document}', parsedArgs.document.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:63
* @route '//dashboard.test/documents/{document}/download'
*/
download.get = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:63
* @route '//dashboard.test/documents/{document}/download'
*/
download.head = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::destroy
* @see app/Http/Controllers/Central/DocumentController.php:74
* @route '//dashboard.test/documents/{document}'
*/
export const destroy = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard.test/documents/{document}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\DocumentController::destroy
* @see app/Http/Controllers/Central/DocumentController.php:74
* @route '//dashboard.test/documents/{document}'
*/
destroy.url = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { document: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { document: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            document: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        document: typeof args.document === 'object'
        ? args.document.id
        : args.document,
    }

    return destroy.definition.url
            .replace('{document}', parsedArgs.document.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\DocumentController::destroy
* @see app/Http/Controllers/Central/DocumentController.php:74
* @route '//dashboard.test/documents/{document}'
*/
destroy.delete = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const documents = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    download: Object.assign(download, download),
    destroy: Object.assign(destroy, destroy),
}

export default documents