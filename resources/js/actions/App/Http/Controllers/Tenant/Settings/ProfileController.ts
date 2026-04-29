import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::edit
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:17
* @route '/profile'
*/
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::edit
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:17
* @route '/profile'
*/
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::edit
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:17
* @route '/profile'
*/
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::edit
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:17
* @route '/profile'
*/
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::update
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:25
* @route '/profile'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/profile',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::update
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:25
* @route '/profile'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::update
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:25
* @route '/profile'
*/
update.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

const ProfileController = { edit, update }

export default ProfileController