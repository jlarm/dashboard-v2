import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\PasswordController::update
* @see app/Http/Controllers/Auth/PasswordController.php:18
* @route '//dashboard.test/password'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '//dashboard.test/password',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Auth\PasswordController::update
* @see app/Http/Controllers/Auth/PasswordController.php:18
* @route '//dashboard.test/password'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\PasswordController::update
* @see app/Http/Controllers/Auth/PasswordController.php:18
* @route '//dashboard.test/password'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

const PasswordController = { update }

export default PasswordController