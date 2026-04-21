import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\Auth\PasswordController::update
* @see app/Http/Controllers/Dealer/Auth/PasswordController.php:18
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
* @see \App\Http\Controllers\Dealer\Auth\PasswordController::update
* @see app/Http/Controllers/Dealer/Auth/PasswordController.php:18
* @route '/password'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\Auth\PasswordController::update
* @see app/Http/Controllers/Dealer/Auth/PasswordController.php:18
* @route '/password'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

const PasswordController = { update }

export default PasswordController