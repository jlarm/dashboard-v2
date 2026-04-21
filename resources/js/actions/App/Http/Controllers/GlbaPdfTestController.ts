import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\GlbaPdfTestController::__invoke
* @see app/Http/Controllers/GlbaPdfTestController.php:12
* @route '/glba-audit-pdf'
*/
const GlbaPdfTestController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlbaPdfTestController.url(options),
    method: 'get',
})

GlbaPdfTestController.definition = {
    methods: ["get","head"],
    url: '/glba-audit-pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GlbaPdfTestController::__invoke
* @see app/Http/Controllers/GlbaPdfTestController.php:12
* @route '/glba-audit-pdf'
*/
GlbaPdfTestController.url = (options?: RouteQueryOptions) => {
    return GlbaPdfTestController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\GlbaPdfTestController::__invoke
* @see app/Http/Controllers/GlbaPdfTestController.php:12
* @route '/glba-audit-pdf'
*/
GlbaPdfTestController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: GlbaPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GlbaPdfTestController::__invoke
* @see app/Http/Controllers/GlbaPdfTestController.php:12
* @route '/glba-audit-pdf'
*/
GlbaPdfTestController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: GlbaPdfTestController.url(options),
    method: 'head',
})

export default GlbaPdfTestController