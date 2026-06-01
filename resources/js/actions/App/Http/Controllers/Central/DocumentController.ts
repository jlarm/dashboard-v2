import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:26
* @route '//dashboard-v2.test/documents'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/documents',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:26
* @route '//dashboard-v2.test/documents'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:26
* @route '//dashboard-v2.test/documents'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:26
* @route '//dashboard-v2.test/documents'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:26
* @route '//dashboard-v2.test/documents'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:26
* @route '//dashboard-v2.test/documents'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::index
* @see app/Http/Controllers/Central/DocumentController.php:26
* @route '//dashboard-v2.test/documents'
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
* @see \App\Http\Controllers\Central\DocumentController::store
* @see app/Http/Controllers/Central/DocumentController.php:49
* @route '//dashboard-v2.test/documents'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard-v2.test/documents',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\DocumentController::store
* @see app/Http/Controllers/Central/DocumentController.php:49
* @route '//dashboard-v2.test/documents'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\DocumentController::store
* @see app/Http/Controllers/Central/DocumentController.php:49
* @route '//dashboard-v2.test/documents'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::store
* @see app/Http/Controllers/Central/DocumentController.php:49
* @route '//dashboard-v2.test/documents'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::store
* @see app/Http/Controllers/Central/DocumentController.php:49
* @route '//dashboard-v2.test/documents'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:66
* @route '//dashboard-v2.test/documents/{document}/download'
*/
export const download = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '//dashboard-v2.test/documents/{document}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:66
* @route '//dashboard-v2.test/documents/{document}/download'
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
* @see app/Http/Controllers/Central/DocumentController.php:66
* @route '//dashboard-v2.test/documents/{document}/download'
*/
download.get = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:66
* @route '//dashboard-v2.test/documents/{document}/download'
*/
download.head = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:66
* @route '//dashboard-v2.test/documents/{document}/download'
*/
const downloadForm = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:66
* @route '//dashboard-v2.test/documents/{document}/download'
*/
downloadForm.get = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::download
* @see app/Http/Controllers/Central/DocumentController.php:66
* @route '//dashboard-v2.test/documents/{document}/download'
*/
downloadForm.head = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Central\DocumentController::destroy
* @see app/Http/Controllers/Central/DocumentController.php:77
* @route '//dashboard-v2.test/documents/{document}'
*/
export const destroy = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard-v2.test/documents/{document}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\DocumentController::destroy
* @see app/Http/Controllers/Central/DocumentController.php:77
* @route '//dashboard-v2.test/documents/{document}'
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
* @see app/Http/Controllers/Central/DocumentController.php:77
* @route '//dashboard-v2.test/documents/{document}'
*/
destroy.delete = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::destroy
* @see app/Http/Controllers/Central/DocumentController.php:77
* @route '//dashboard-v2.test/documents/{document}'
*/
const destroyForm = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\DocumentController::destroy
* @see app/Http/Controllers/Central/DocumentController.php:77
* @route '//dashboard-v2.test/documents/{document}'
*/
destroyForm.delete = (args: { document: number | { id: number } } | [document: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const DocumentController = { index, store, download, destroy }

export default DocumentController