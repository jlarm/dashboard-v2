import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Central\ViolationStatementController::index
* @see app/Http/Controllers/Central/ViolationStatementController.php:28
* @route '//dashboard.test/violation-statements'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/violation-statements',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::index
* @see app/Http/Controllers/Central/ViolationStatementController.php:28
* @route '//dashboard.test/violation-statements'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::index
* @see app/Http/Controllers/Central/ViolationStatementController.php:28
* @route '//dashboard.test/violation-statements'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::index
* @see app/Http/Controllers/Central/ViolationStatementController.php:28
* @route '//dashboard.test/violation-statements'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::store
* @see app/Http/Controllers/Central/ViolationStatementController.php:57
* @route '//dashboard.test/violation-statements'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/violation-statements',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::store
* @see app/Http/Controllers/Central/ViolationStatementController.php:57
* @route '//dashboard.test/violation-statements'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::store
* @see app/Http/Controllers/Central/ViolationStatementController.php:57
* @route '//dashboard.test/violation-statements'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::update
* @see app/Http/Controllers/Central/ViolationStatementController.php:69
* @route '//dashboard.test/violation-statements/{violationStatement}'
*/
export const update = (args: { violationStatement: number | { id: number } } | [violationStatement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '//dashboard.test/violation-statements/{violationStatement}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::update
* @see app/Http/Controllers/Central/ViolationStatementController.php:69
* @route '//dashboard.test/violation-statements/{violationStatement}'
*/
update.url = (args: { violationStatement: number | { id: number } } | [violationStatement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { violationStatement: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { violationStatement: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            violationStatement: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        violationStatement: typeof args.violationStatement === 'object'
        ? args.violationStatement.id
        : args.violationStatement,
    }

    return update.definition.url
            .replace('{violationStatement}', parsedArgs.violationStatement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::update
* @see app/Http/Controllers/Central/ViolationStatementController.php:69
* @route '//dashboard.test/violation-statements/{violationStatement}'
*/
update.patch = (args: { violationStatement: number | { id: number } } | [violationStatement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::destroy
* @see app/Http/Controllers/Central/ViolationStatementController.php:85
* @route '//dashboard.test/violation-statements/{violationStatement}'
*/
export const destroy = (args: { violationStatement: number | { id: number } } | [violationStatement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard.test/violation-statements/{violationStatement}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::destroy
* @see app/Http/Controllers/Central/ViolationStatementController.php:85
* @route '//dashboard.test/violation-statements/{violationStatement}'
*/
destroy.url = (args: { violationStatement: number | { id: number } } | [violationStatement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { violationStatement: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { violationStatement: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            violationStatement: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        violationStatement: typeof args.violationStatement === 'object'
        ? args.violationStatement.id
        : args.violationStatement,
    }

    return destroy.definition.url
            .replace('{violationStatement}', parsedArgs.violationStatement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ViolationStatementController::destroy
* @see app/Http/Controllers/Central/ViolationStatementController.php:85
* @route '//dashboard.test/violation-statements/{violationStatement}'
*/
destroy.delete = (args: { violationStatement: number | { id: number } } | [violationStatement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const violationStatements = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default violationStatements