import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\SharedDocumentController::index
* @see app/Http/Controllers/Central/SharedDocumentController.php:26
* @route '//dashboard-v2.test/shared-documents'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/shared-documents',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::index
* @see app/Http/Controllers/Central/SharedDocumentController.php:26
* @route '//dashboard-v2.test/shared-documents'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::index
* @see app/Http/Controllers/Central/SharedDocumentController.php:26
* @route '//dashboard-v2.test/shared-documents'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::index
* @see app/Http/Controllers/Central/SharedDocumentController.php:26
* @route '//dashboard-v2.test/shared-documents'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::index
* @see app/Http/Controllers/Central/SharedDocumentController.php:26
* @route '//dashboard-v2.test/shared-documents'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::index
* @see app/Http/Controllers/Central/SharedDocumentController.php:26
* @route '//dashboard-v2.test/shared-documents'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::index
* @see app/Http/Controllers/Central/SharedDocumentController.php:26
* @route '//dashboard-v2.test/shared-documents'
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
* @see \App\Http\Controllers\Central\SharedDocumentController::store
* @see app/Http/Controllers/Central/SharedDocumentController.php:49
* @route '//dashboard-v2.test/shared-documents'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard-v2.test/shared-documents',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::store
* @see app/Http/Controllers/Central/SharedDocumentController.php:49
* @route '//dashboard-v2.test/shared-documents'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::store
* @see app/Http/Controllers/Central/SharedDocumentController.php:49
* @route '//dashboard-v2.test/shared-documents'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::store
* @see app/Http/Controllers/Central/SharedDocumentController.php:49
* @route '//dashboard-v2.test/shared-documents'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::store
* @see app/Http/Controllers/Central/SharedDocumentController.php:49
* @route '//dashboard-v2.test/shared-documents'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::download
* @see app/Http/Controllers/Central/SharedDocumentController.php:66
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}/download'
*/
export const download = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/shared-documents/{sharedDocument}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::download
* @see app/Http/Controllers/Central/SharedDocumentController.php:66
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}/download'
*/
download.url = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sharedDocument: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { sharedDocument: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            sharedDocument: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        sharedDocument: typeof args.sharedDocument === 'object'
        ? args.sharedDocument.id
        : args.sharedDocument,
    }

    return download.definition.url
            .replace('{sharedDocument}', parsedArgs.sharedDocument.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::download
* @see app/Http/Controllers/Central/SharedDocumentController.php:66
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}/download'
*/
download.get = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::download
* @see app/Http/Controllers/Central/SharedDocumentController.php:66
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}/download'
*/
download.head = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::download
* @see app/Http/Controllers/Central/SharedDocumentController.php:66
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}/download'
*/
const downloadForm = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::download
* @see app/Http/Controllers/Central/SharedDocumentController.php:66
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}/download'
*/
downloadForm.get = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::download
* @see app/Http/Controllers/Central/SharedDocumentController.php:66
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}/download'
*/
downloadForm.head = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Central\SharedDocumentController::destroy
* @see app/Http/Controllers/Central/SharedDocumentController.php:77
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}'
*/
export const destroy = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard-v2.test/shared-documents/{sharedDocument}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::destroy
* @see app/Http/Controllers/Central/SharedDocumentController.php:77
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}'
*/
destroy.url = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sharedDocument: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { sharedDocument: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            sharedDocument: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        sharedDocument: typeof args.sharedDocument === 'object'
        ? args.sharedDocument.id
        : args.sharedDocument,
    }

    return destroy.definition.url
            .replace('{sharedDocument}', parsedArgs.sharedDocument.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::destroy
* @see app/Http/Controllers/Central/SharedDocumentController.php:77
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}'
*/
destroy.delete = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::destroy
* @see app/Http/Controllers/Central/SharedDocumentController.php:77
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}'
*/
const destroyForm = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\SharedDocumentController::destroy
* @see app/Http/Controllers/Central/SharedDocumentController.php:77
* @route '//dashboard-v2.test/shared-documents/{sharedDocument}'
*/
destroyForm.delete = (args: { sharedDocument: number | { id: number } } | [sharedDocument: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const SharedDocumentController = { index, store, download, destroy }

export default SharedDocumentController