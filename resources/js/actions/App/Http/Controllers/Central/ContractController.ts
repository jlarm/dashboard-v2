import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contracts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::index
* @see app/Http/Controllers/Central/ContractController.php:28
* @route '//dashboard.test/contracts'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contracts/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::create
* @see app/Http/Controllers/Central/ContractController.php:43
* @route '//dashboard.test/contracts/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractController::store
* @see app/Http/Controllers/Central/ContractController.php:52
* @route '//dashboard.test/contracts'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '//dashboard.test/contracts',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ContractController::store
* @see app/Http/Controllers/Central/ContractController.php:52
* @route '//dashboard.test/contracts'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::store
* @see app/Http/Controllers/Central/ContractController.php:52
* @route '//dashboard.test/contracts'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
export const edit = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contracts/{contract}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
edit.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return edit.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
edit.get = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractController::edit
* @see app/Http/Controllers/Central/ContractController.php:63
* @route '//dashboard.test/contracts/{contract}'
*/
edit.head = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractController::update
* @see app/Http/Controllers/Central/ContractController.php:90
* @route '//dashboard.test/contracts/{contract}'
*/
export const update = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '//dashboard.test/contracts/{contract}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Central\ContractController::update
* @see app/Http/Controllers/Central/ContractController.php:90
* @route '//dashboard.test/contracts/{contract}'
*/
update.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return update.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::update
* @see app/Http/Controllers/Central/ContractController.php:90
* @route '//dashboard.test/contracts/{contract}'
*/
update.patch = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Central\ContractController::destroy
* @see app/Http/Controllers/Central/ContractController.php:100
* @route '//dashboard.test/contracts/{contract}'
*/
export const destroy = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '//dashboard.test/contracts/{contract}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Central\ContractController::destroy
* @see app/Http/Controllers/Central/ContractController.php:100
* @route '//dashboard.test/contracts/{contract}'
*/
destroy.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { contract: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { contract: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            contract: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        contract: typeof args.contract === 'object'
        ? args.contract.uuid
        : args.contract,
    }

    return destroy.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractController::destroy
* @see app/Http/Controllers/Central/ContractController.php:100
* @route '//dashboard.test/contracts/{contract}'
*/
destroy.delete = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const ContractController = { index, create, store, edit, update, destroy }

export default ContractController