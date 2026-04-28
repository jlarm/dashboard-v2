import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
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
* @see \App\Http\Controllers\Tenant\SdsController::storeRequest
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
export const storeRequest = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeRequest.url(options),
    method: 'post',
})

storeRequest.definition = {
    methods: ["post"],
    url: '/sds-sheets/request',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\SdsController::storeRequest
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
storeRequest.url = (options?: RouteQueryOptions) => {
    return storeRequest.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\SdsController::storeRequest
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
storeRequest.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeRequest.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::storeRequest
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
const storeRequestForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeRequest.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\SdsController::storeRequest
* @see app/Http/Controllers/Tenant/SdsController.php:58
* @route '/sds-sheets/request'
*/
storeRequestForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeRequest.url(options),
    method: 'post',
})

storeRequest.form = storeRequestForm

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

const SdsController = { index, storeRequest, view }

export default SdsController