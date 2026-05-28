import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
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
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::edit
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:17
* @route '/profile'
*/
const editForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::edit
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:17
* @route '/profile'
*/
editForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::edit
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:17
* @route '/profile'
*/
editForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::update
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:24
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
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:24
* @route '/profile'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::update
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:24
* @route '/profile'
*/
update.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::update
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:24
* @route '/profile'
*/
const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\ProfileController::update
* @see app/Http/Controllers/Tenant/Settings/ProfileController.php:24
* @route '/profile'
*/
updateForm.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

const profile = {
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
}

export default profile