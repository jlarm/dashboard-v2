import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
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

export default AuthController