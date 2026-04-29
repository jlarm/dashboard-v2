import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\SdsController::index
* @see app/Http/Controllers/Tenant/SdsController.php:22
* @route '/sds-sheets'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/sds-sheets',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\SdsController::index
* @see app/Http/Controllers/Tenant/SdsController.php:22
* @route '/sds-sheets'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\SdsController::index
* @see app/Http/Controllers/Tenant/SdsController.php:22
* @route '/sds-sheets'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::index
* @see app/Http/Controllers/Tenant/SdsController.php:22
* @route '/sds-sheets'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::index
* @see app/Http/Controllers/Tenant/SdsController.php:22
* @route '/sds-sheets'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::index
* @see app/Http/Controllers/Tenant/SdsController.php:22
* @route '/sds-sheets'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::index
* @see app/Http/Controllers/Tenant/SdsController.php:22
* @route '/sds-sheets'
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
* @see \App\Http\Controllers\Tenant\SdsController::request
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
export const request = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: request.url(options),
    method: 'post',
})

request.definition = {
    methods: ["post"],
    url: '/sds-sheets/request',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\SdsController::request
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
request.url = (options?: RouteQueryOptions) => {
    return request.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\SdsController::request
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
request.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: request.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::request
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
const requestForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: request.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::request
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
requestForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: request.url(options),
    method: 'post',
})

request.form = requestForm

/**
* @see \App\Http\Controllers\Tenant\SdsController::view
* @see app/Http/Controllers/Tenant/SdsController.php:42
* @route '/sds-sheets/{uuid}/view'
*/
export const view = (args: { uuid: string | number } | [uuid: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/sds-sheets/{uuid}/view',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\SdsController::view
* @see app/Http/Controllers/Tenant/SdsController.php:42
* @route '/sds-sheets/{uuid}/view'
*/
view.url = (args: { uuid: string | number } | [uuid: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { uuid: args }
    }

    if (Array.isArray(args)) {
        args = {
            uuid: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        uuid: args.uuid,
    }

    return view.definition.url
            .replace('{uuid}', parsedArgs.uuid.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\SdsController::view
* @see app/Http/Controllers/Tenant/SdsController.php:42
* @route '/sds-sheets/{uuid}/view'
*/
view.get = (args: { uuid: string | number } | [uuid: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::view
* @see app/Http/Controllers/Tenant/SdsController.php:42
* @route '/sds-sheets/{uuid}/view'
*/
view.head = (args: { uuid: string | number } | [uuid: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::view
* @see app/Http/Controllers/Tenant/SdsController.php:42
* @route '/sds-sheets/{uuid}/view'
*/
const viewForm = (args: { uuid: string | number } | [uuid: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: view.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::view
* @see app/Http/Controllers/Tenant/SdsController.php:42
* @route '/sds-sheets/{uuid}/view'
*/
viewForm.get = (args: { uuid: string | number } | [uuid: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: view.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::view
* @see app/Http/Controllers/Tenant/SdsController.php:42
* @route '/sds-sheets/{uuid}/view'
*/
viewForm.head = (args: { uuid: string | number } | [uuid: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: view.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

view.form = viewForm

const sds = {
    index: Object.assign(index, index),
    request: Object.assign(request, request),
    view: Object.assign(view, view),
}

export default sds