import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\BodyShopPdfTestController::__invoke
* @see app/Http/Controllers/BodyShopPdfTestController.php:12
* @route '/body-shop-audit-pdf'
*/
const BodyShopPdfTestController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: BodyShopPdfTestController.url(options),
    method: 'get',
})

BodyShopPdfTestController.definition = {
    methods: ["get","head"],
    url: '/body-shop-audit-pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BodyShopPdfTestController::__invoke
* @see app/Http/Controllers/BodyShopPdfTestController.php:12
* @route '/body-shop-audit-pdf'
*/
BodyShopPdfTestController.url = (options?: RouteQueryOptions) => {
    return BodyShopPdfTestController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BodyShopPdfTestController::__invoke
* @see app/Http/Controllers/BodyShopPdfTestController.php:12
* @route '/body-shop-audit-pdf'
*/
BodyShopPdfTestController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: BodyShopPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\BodyShopPdfTestController::__invoke
* @see app/Http/Controllers/BodyShopPdfTestController.php:12
* @route '/body-shop-audit-pdf'
*/
BodyShopPdfTestController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: BodyShopPdfTestController.url(options),
    method: 'head',
})

export default BodyShopPdfTestController