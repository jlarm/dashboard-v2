import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
export const auth = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: auth.url(options),
    method: 'post',
})

auth.definition = {
    methods: ["post"],
    url: '//dashboard.test/api/auth',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
auth.url = (options?: RouteQueryOptions) => {
    return auth.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
auth.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: auth.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
const authForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: auth.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\API\AuthController::__invoke
* @see app/Http/Controllers/API/AuthController.php:17
* @route '//dashboard.test/api/auth'
*/
authForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: auth.url(options),
    method: 'post',
})

auth.form = authForm

const api = {
    auth: Object.assign(auth, auth),
}

export default api