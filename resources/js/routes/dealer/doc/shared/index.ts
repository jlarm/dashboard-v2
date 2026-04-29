import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:74
* @route '/documents/shared/{sharedDocument}/download'
*/
export const download = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/documents/shared/{sharedDocument}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:74
* @route '/documents/shared/{sharedDocument}/download'
*/
download.url = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return download.definition.url
            .replace('{sharedDocument}', parsedArgs.sharedDocument.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:74
* @route '/documents/shared/{sharedDocument}/download'
*/
download.get = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:74
* @route '/documents/shared/{sharedDocument}/download'
*/
download.head = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:74
* @route '/documents/shared/{sharedDocument}/download'
*/
const downloadForm = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:74
* @route '/documents/shared/{sharedDocument}/download'
*/
downloadForm.get = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\DealerDocController::download
* @see app/Http/Controllers/Tenant/DealerDocController.php:74
* @route '/documents/shared/{sharedDocument}/download'
*/
downloadForm.head = (args: { sharedDocument: string | number } | [sharedDocument: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

download.form = downloadForm

const shared = {
    download: Object.assign(download, download),
}

export default shared