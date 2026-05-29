import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::edit
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:16
* @route '/password'
*/
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/password',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::edit
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:16
* @route '/password'
*/
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::edit
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:16
* @route '/password'
*/
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::edit
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:16
* @route '/password'
*/
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::update
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:21
* @route '/password'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/password',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::update
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:21
* @route '/password'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::update
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:21
* @route '/password'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

const PasswordController = { edit, update }

export default PasswordController