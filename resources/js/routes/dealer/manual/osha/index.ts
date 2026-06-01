import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::index
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:33
* @route '/manuals/osha'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/manuals/osha',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::index
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:33
* @route '/manuals/osha'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::index
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:33
* @route '/manuals/osha'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::index
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:33
* @route '/manuals/osha'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::index
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:33
* @route '/manuals/osha'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::index
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:33
* @route '/manuals/osha'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::index
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:33
* @route '/manuals/osha'
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
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::create
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:52
* @route '/manuals/osha/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/manuals/osha/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::create
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:52
* @route '/manuals/osha/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::create
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:52
* @route '/manuals/osha/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::create
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:52
* @route '/manuals/osha/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::create
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:52
* @route '/manuals/osha/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::create
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:52
* @route '/manuals/osha/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::create
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:52
* @route '/manuals/osha/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::store
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:64
* @route '/manuals/osha'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/manuals/osha',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::store
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:64
* @route '/manuals/osha'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::store
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:64
* @route '/manuals/osha'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::store
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:64
* @route '/manuals/osha'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::store
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:64
* @route '/manuals/osha'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::download
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:91
* @route '/manuals/osha/{manual}/download'
*/
export const download = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/manuals/osha/{manual}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::download
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:91
* @route '/manuals/osha/{manual}/download'
*/
download.url = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { manual: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { manual: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            manual: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        manual: typeof args.manual === 'object'
        ? args.manual.id
        : args.manual,
    }

    return download.definition.url
            .replace('{manual}', parsedArgs.manual.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::download
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:91
* @route '/manuals/osha/{manual}/download'
*/
download.get = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::download
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:91
* @route '/manuals/osha/{manual}/download'
*/
download.head = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::download
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:91
* @route '/manuals/osha/{manual}/download'
*/
const downloadForm = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::download
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:91
* @route '/manuals/osha/{manual}/download'
*/
downloadForm.get = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::download
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:91
* @route '/manuals/osha/{manual}/download'
*/
downloadForm.head = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: download.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

download.form = downloadForm

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::destroy
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:79
* @route '/manuals/osha/{manual}'
*/
export const destroy = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/manuals/osha/{manual}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::destroy
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:79
* @route '/manuals/osha/{manual}'
*/
destroy.url = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { manual: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { manual: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            manual: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        manual: typeof args.manual === 'object'
        ? args.manual.id
        : args.manual,
    }

    return destroy.definition.url
            .replace('{manual}', parsedArgs.manual.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::destroy
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:79
* @route '/manuals/osha/{manual}'
*/
destroy.delete = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::destroy
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:79
* @route '/manuals/osha/{manual}'
*/
const destroyForm = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Manuals\OshaController::destroy
* @see app/Http/Controllers/Tenant/Manuals/OshaController.php:79
* @route '/manuals/osha/{manual}'
*/
destroyForm.delete = (args: { manual: string | number | { id: string | number } } | [manual: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const osha = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    download: Object.assign(download, download),
    destroy: Object.assign(destroy, destroy),
}

export default osha