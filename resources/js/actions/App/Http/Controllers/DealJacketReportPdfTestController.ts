import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
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

/**
* @see \App\Http\Controllers\DealJacketReportPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketReportPdfTestController.php:14
* @route '/deal-jacket-report-pdf'
*/
const DealJacketReportPdfTestControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: DealJacketReportPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DealJacketReportPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketReportPdfTestController.php:14
* @route '/deal-jacket-report-pdf'
*/
DealJacketReportPdfTestControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: DealJacketReportPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DealJacketReportPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketReportPdfTestController.php:14
* @route '/deal-jacket-report-pdf'
*/
DealJacketReportPdfTestControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: DealJacketReportPdfTestController.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

DealJacketReportPdfTestController.form = DealJacketReportPdfTestControllerForm

export default DealJacketReportPdfTestController