import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
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

const DealJacketReportDownloadController = { download }

export default DealJacketReportDownloadController