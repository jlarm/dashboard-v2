import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\SdsController::index
* @see app/Http/Controllers/Central/SdsController.php:27
* @route '//dashboard.test/sds'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/sds',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\SdsController::index
* @see app/Http/Controllers/Central/SdsController.php:27
* @route '//dashboard.test/sds'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SdsController::index
* @see app/Http/Controllers/Central/SdsController.php:27
* @route '//dashboard.test/sds'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\SdsController::index
* @see app/Http/Controllers/Central/SdsController.php:27
* @route '//dashboard.test/sds'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\SdsController::store
* @see app/Http/Controllers/Central/SdsController.php:47
* @route '//dashboard.test/sds'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/sds',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\SdsController::store
* @see app/Http/Controllers/Central/SdsController.php:47
* @route '//dashboard.test/sds'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SdsController::store
* @see app/Http/Controllers/Central/SdsController.php:47
* @route '//dashboard.test/sds'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\SdsController::update
* @see app/Http/Controllers/Central/SdsController.php:56
* @route '//dashboard.test/sds/{sds}'
*/
export const update = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '//dashboard.test/sds/{sds}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Central\SdsController::update
* @see app/Http/Controllers/Central/SdsController.php:56
* @route '//dashboard.test/sds/{sds}'
*/
update.url = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sds: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { sds: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            sds: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        sds: typeof args.sds === 'object'
        ? args.sds.uuid
        : args.sds,
    }

    return update.definition.url
            .replace('{sds}', parsedArgs.sds.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SdsController::update
* @see app/Http/Controllers/Central/SdsController.php:56
* @route '//dashboard.test/sds/{sds}'
*/
update.patch = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Central\SdsController::destroy
* @see app/Http/Controllers/Central/SdsController.php:65
* @route '//dashboard.test/sds/{sds}'
*/
export const destroy = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard.test/sds/{sds}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\SdsController::destroy
* @see app/Http/Controllers/Central/SdsController.php:65
* @route '//dashboard.test/sds/{sds}'
*/
destroy.url = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sds: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { sds: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            sds: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        sds: typeof args.sds === 'object'
        ? args.sds.uuid
        : args.sds,
    }

    return destroy.definition.url
            .replace('{sds}', parsedArgs.sds.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SdsController::destroy
* @see app/Http/Controllers/Central/SdsController.php:65
* @route '//dashboard.test/sds/{sds}'
*/
destroy.delete = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Central\SdsController::download
* @see app/Http/Controllers/Central/SdsController.php:74
* @route '//dashboard.test/sds/{sds}/download'
*/
export const download = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/sds/{sds}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\SdsController::download
* @see app/Http/Controllers/Central/SdsController.php:74
* @route '//dashboard.test/sds/{sds}/download'
*/
download.url = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sds: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { sds: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            sds: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        sds: typeof args.sds === 'object'
        ? args.sds.uuid
        : args.sds,
    }

    return download.definition.url
            .replace('{sds}', parsedArgs.sds.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\SdsController::download
* @see app/Http/Controllers/Central/SdsController.php:74
* @route '//dashboard.test/sds/{sds}/download'
*/
download.get = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\SdsController::download
* @see app/Http/Controllers/Central/SdsController.php:74
* @route '//dashboard.test/sds/{sds}/download'
*/
download.head = (args: { sds: string | { uuid: string } } | [sds: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

const SdsController = { index, store, update, destroy, download }

export default SdsController