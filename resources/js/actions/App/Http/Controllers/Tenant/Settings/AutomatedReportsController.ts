import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::index
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:30
* @route '/automated-reports'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/automated-reports',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::index
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:30
* @route '/automated-reports'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::index
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:30
* @route '/automated-reports'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::index
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:30
* @route '/automated-reports'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::update
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:62
* @route '/automated-reports'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/automated-reports',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::update
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:62
* @route '/automated-reports'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::update
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:62
* @route '/automated-reports'
*/
update.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::sendNow
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:73
* @route '/automated-reports/send'
*/
export const sendNow = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendNow.url(options),
    method: 'post',
})

sendNow.definition = {
    methods: ["post"],
    url: '/automated-reports/send',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::sendNow
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:73
* @route '/automated-reports/send'
*/
sendNow.url = (options?: RouteQueryOptions) => {
    return sendNow.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::sendNow
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:73
* @route '/automated-reports/send'
*/
sendNow.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendNow.url(options),
    method: 'post',
})

const AutomatedReportsController = { index, update, sendNow }

export default AutomatedReportsController