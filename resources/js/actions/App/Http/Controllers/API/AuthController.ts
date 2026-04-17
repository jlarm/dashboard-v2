import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
const AuthController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: AuthController.url(options),
    method: 'post',
})

AuthController.definition = {
    methods: ["post"],
    url: '//dashboard.test/api/auth',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
AuthController.url = (options?: RouteQueryOptions) => {
    return AuthController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
AuthController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: AuthController.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
const AuthControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: AuthController.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
AuthControllerForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: AuthController.url(options),
    method: 'post',
})

AuthController.form = AuthControllerForm

export default AuthController