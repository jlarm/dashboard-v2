import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::download
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
export const download = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/scans/report/{type}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::download
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
download.url = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { type: args }
    }

    if (Array.isArray(args)) {
        args = {
            type: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        type: args.type,
    }

    return download.definition.url
            .replace('{type}', parsedArgs.type.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::download
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
download.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::download
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
download.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::download
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
const downloadForm = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::download
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
downloadForm.get = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\CyrismaReportController::download
* @see app/Http/Controllers/Tenant/CyrismaReportController.php:18
* @route '/scans/report/{type}'
*/
downloadForm.head = (args: { type: string | number } | [type: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

download.form = downloadForm

const CyrismaReportController = { download }

export default CyrismaReportController