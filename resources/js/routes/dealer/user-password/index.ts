import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::edit
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:15
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
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:15
* @route '/password'
*/
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::edit
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:15
* @route '/password'
*/
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\PasswordController::edit
* @see app/Http/Controllers/Tenant/Settings/PasswordController.php:15
* @route '/password'
*/
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

const userPassword = {
    edit: Object.assign(edit, edit),
}

export default userPassword