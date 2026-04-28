import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
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
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::index
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:30
* @route '/automated-reports'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::index
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:30
* @route '/automated-reports'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::index
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:30
* @route '/automated-reports'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

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
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::update
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:62
* @route '/automated-reports'
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
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::update
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:62
* @route '/automated-reports'
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

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::send
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:73
* @route '/automated-reports/send'
*/
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/automated-reports/send',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::send
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:73
* @route '/automated-reports/send'
*/
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::send
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:73
* @route '/automated-reports/send'
*/
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::send
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:73
* @route '/automated-reports/send'
*/
const sendForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: send.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\AutomatedReportsController::send
* @see app/Http/Controllers/Tenant/Settings/AutomatedReportsController.php:73
* @route '/automated-reports/send'
*/
sendForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: send.url(options),
    method: 'post',
})

send.form = sendForm

const automatedReports = {
    index: Object.assign(index, index),
    update: Object.assign(update, update),
    send: Object.assign(send, send),
}

export default automatedReports