import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\DealJacketReportPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketReportPdfTestController.php:14
* @route '/deal-jacket-report-pdf'
*/
const DealJacketReportPdfTestController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DealJacketReportPdfTestController.url(options),
    method: 'get',
})

DealJacketReportPdfTestController.definition = {
    methods: ["get","head"],
    url: '/deal-jacket-report-pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DealJacketReportPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketReportPdfTestController.php:14
* @route '/deal-jacket-report-pdf'
*/
DealJacketReportPdfTestController.url = (options?: RouteQueryOptions) => {
    return DealJacketReportPdfTestController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DealJacketReportPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketReportPdfTestController.php:14
* @route '/deal-jacket-report-pdf'
*/
DealJacketReportPdfTestController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DealJacketReportPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DealJacketReportPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketReportPdfTestController.php:14
* @route '/deal-jacket-report-pdf'
*/
DealJacketReportPdfTestController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: DealJacketReportPdfTestController.url(options),
    method: 'head',
})

export default DealJacketReportPdfTestController