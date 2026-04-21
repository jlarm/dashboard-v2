import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\DealJacketPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketPdfTestController.php:24
* @route '/deal-jacket-audit-pdf'
*/
const DealJacketPdfTestController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DealJacketPdfTestController.url(options),
    method: 'get',
})

DealJacketPdfTestController.definition = {
    methods: ["get","head"],
    url: '/deal-jacket-audit-pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DealJacketPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketPdfTestController.php:24
* @route '/deal-jacket-audit-pdf'
*/
DealJacketPdfTestController.url = (options?: RouteQueryOptions) => {
    return DealJacketPdfTestController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DealJacketPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketPdfTestController.php:24
* @route '/deal-jacket-audit-pdf'
*/
DealJacketPdfTestController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DealJacketPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DealJacketPdfTestController::__invoke
* @see app/Http/Controllers/DealJacketPdfTestController.php:24
* @route '/deal-jacket-audit-pdf'
*/
DealJacketPdfTestController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: DealJacketPdfTestController.url(options),
    method: 'head',
})

export default DealJacketPdfTestController