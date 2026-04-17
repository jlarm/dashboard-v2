import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController::download
* @see app/Http/Controllers/Tenant/Audit/DealJacketReportDownloadController.php:14
* @route '/audits/deal-jacket-reports/{fileName}/download'
*/
export const download = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jacket-reports/{fileName}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController::download
* @see app/Http/Controllers/Tenant/Audit/DealJacketReportDownloadController.php:14
* @route '/audits/deal-jacket-reports/{fileName}/download'
*/
download.url = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { fileName: args }
    }

    if (Array.isArray(args)) {
        args = {
            fileName: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        fileName: args.fileName,
    }

    return download.definition.url
            .replace('{fileName}', parsedArgs.fileName.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController::download
* @see app/Http/Controllers/Tenant/Audit/DealJacketReportDownloadController.php:14
* @route '/audits/deal-jacket-reports/{fileName}/download'
*/
download.get = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController::download
* @see app/Http/Controllers/Tenant/Audit/DealJacketReportDownloadController.php:14
* @route '/audits/deal-jacket-reports/{fileName}/download'
*/
download.head = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController::download
* @see app/Http/Controllers/Tenant/Audit/DealJacketReportDownloadController.php:14
* @route '/audits/deal-jacket-reports/{fileName}/download'
*/
const downloadForm = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController::download
* @see app/Http/Controllers/Tenant/Audit/DealJacketReportDownloadController.php:14
* @route '/audits/deal-jacket-reports/{fileName}/download'
*/
downloadForm.get = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketReportDownloadController::download
* @see app/Http/Controllers/Tenant/Audit/DealJacketReportDownloadController.php:14
* @route '/audits/deal-jacket-reports/{fileName}/download'
*/
downloadForm.head = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

download.form = downloadForm

const dealJacketReports = {
    download: Object.assign(download, download),
}

export default dealJacketReports