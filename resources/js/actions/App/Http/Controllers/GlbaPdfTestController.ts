import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
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

/**
* @see \App\Http\Controllers\GlbaPdfTestController::__invoke
* @see app/Http/Controllers/GlbaPdfTestController.php:12
* @route '/glba-audit-pdf'
*/
const GlbaPdfTestControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlbaPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GlbaPdfTestController::__invoke
* @see app/Http/Controllers/GlbaPdfTestController.php:12
* @route '/glba-audit-pdf'
*/
GlbaPdfTestControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlbaPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GlbaPdfTestController::__invoke
* @see app/Http/Controllers/GlbaPdfTestController.php:12
* @route '/glba-audit-pdf'
*/
GlbaPdfTestControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: GlbaPdfTestController.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

GlbaPdfTestController.form = GlbaPdfTestControllerForm

export default GlbaPdfTestController