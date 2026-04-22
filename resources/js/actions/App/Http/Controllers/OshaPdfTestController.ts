import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\OshaPdfTestController::__invoke
* @see app/Http/Controllers/OshaPdfTestController.php:12
* @route '/osha-audit-pdf'
*/
const OshaPdfTestController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: OshaPdfTestController.url(options),
    method: 'get',
})

OshaPdfTestController.definition = {
    methods: ["get","head"],
    url: '/osha-audit-pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\OshaPdfTestController::__invoke
* @see app/Http/Controllers/OshaPdfTestController.php:12
* @route '/osha-audit-pdf'
*/
OshaPdfTestController.url = (options?: RouteQueryOptions) => {
    return OshaPdfTestController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\OshaPdfTestController::__invoke
* @see app/Http/Controllers/OshaPdfTestController.php:12
* @route '/osha-audit-pdf'
*/
OshaPdfTestController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: OshaPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\OshaPdfTestController::__invoke
* @see app/Http/Controllers/OshaPdfTestController.php:12
* @route '/osha-audit-pdf'
*/
OshaPdfTestController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: OshaPdfTestController.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\OshaPdfTestController::__invoke
* @see app/Http/Controllers/OshaPdfTestController.php:12
* @route '/osha-audit-pdf'
*/
const OshaPdfTestControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: OshaPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\OshaPdfTestController::__invoke
* @see app/Http/Controllers/OshaPdfTestController.php:12
* @route '/osha-audit-pdf'
*/
OshaPdfTestControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: OshaPdfTestController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\OshaPdfTestController::__invoke
* @see app/Http/Controllers/OshaPdfTestController.php:12
* @route '/osha-audit-pdf'
*/
OshaPdfTestControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: OshaPdfTestController.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

OshaPdfTestController.form = OshaPdfTestControllerForm

export default OshaPdfTestController