import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\EmployeeIndexController::__invoke
* @see app/Http/Controllers/Dealer/EmployeeIndexController.php:12
* @route '/employees'
*/
const EmployeeIndexController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EmployeeIndexController.url(options),
    method: 'get',
})

EmployeeIndexController.definition = {
    methods: ["get","head"],
    url: '/employees',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\EmployeeIndexController::__invoke
* @see app/Http/Controllers/Dealer/EmployeeIndexController.php:12
* @route '/employees'
*/
EmployeeIndexController.url = (options?: RouteQueryOptions) => {
    return EmployeeIndexController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\EmployeeIndexController::__invoke
* @see app/Http/Controllers/Dealer/EmployeeIndexController.php:12
* @route '/employees'
*/
EmployeeIndexController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EmployeeIndexController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\EmployeeIndexController::__invoke
* @see app/Http/Controllers/Dealer/EmployeeIndexController.php:12
* @route '/employees'
*/
EmployeeIndexController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EmployeeIndexController.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\EmployeeIndexController::__invoke
* @see app/Http/Controllers/Dealer/EmployeeIndexController.php:12
* @route '/employees'
*/
const EmployeeIndexControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EmployeeIndexController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\EmployeeIndexController::__invoke
* @see app/Http/Controllers/Dealer/EmployeeIndexController.php:12
* @route '/employees'
*/
EmployeeIndexControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EmployeeIndexController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\EmployeeIndexController::__invoke
* @see app/Http/Controllers/Dealer/EmployeeIndexController.php:12
* @route '/employees'
*/
EmployeeIndexControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EmployeeIndexController.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EmployeeIndexController.form = EmployeeIndexControllerForm

export default EmployeeIndexController