import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:105
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
export const create = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:105
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
create.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealJacketGroup: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { dealJacketGroup: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
    }

    return create.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:105
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
create.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::create
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:105
* @route '/audits/deal-jackets/{dealJacketGroup}/create'
*/
create.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::store
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:145
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets'
*/
export const store = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets/{dealJacketGroup}/jackets',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::store
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:145
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets'
*/
store.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealJacketGroup: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { dealJacketGroup: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
    }

    return store.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::store
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:145
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets'
*/
store.post = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:124
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
export const edit = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:124
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.url = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
            dealJacket: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
        dealJacket: args.dealJacket,
    }

    return edit.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace('{dealJacket}', parsedArgs.dealJacket.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:124
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.get = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::edit
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:124
* @route '/audits/deal-jackets/{dealJacketGroup}/edit/{dealJacket}'
*/
edit.head = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::update
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:159
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
export const update = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::update
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:159
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
update.url = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
            dealJacket: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
        dealJacket: args.dealJacket,
    }

    return update.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace('{dealJacket}', parsedArgs.dealJacket.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::update
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:159
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
update.patch = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroy
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:175
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
export const destroy = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroy
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:175
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
destroy.url = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
            dealJacket: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
        dealJacket: args.dealJacket,
    }

    return destroy.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace('{dealJacket}', parsedArgs.dealJacket.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroy
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:175
* @route '/audits/deal-jackets/{dealJacketGroup}/jackets/{dealJacket}'
*/
destroy.delete = (args: { dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number } | [dealJacketGroup: string | number | { uuid: string | number }, dealJacket: string | number ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::startGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:53
* @route '/audits/deal-jackets'
*/
export const startGroup = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: startGroup.url(options),
    method: 'post',
})

startGroup.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::startGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:53
* @route '/audits/deal-jackets'
*/
startGroup.url = (options?: RouteQueryOptions) => {
    return startGroup.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::startGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:53
* @route '/audits/deal-jackets'
*/
startGroup.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: startGroup.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::complete
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:80
* @route '/audits/deal-jackets/{dealJacketGroup}/complete'
*/
export const complete = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: complete.url(args, options),
    method: 'post',
})

complete.definition = {
    methods: ["post"],
    url: '/audits/deal-jackets/{dealJacketGroup}/complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::complete
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:80
* @route '/audits/deal-jackets/{dealJacketGroup}/complete'
*/
complete.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealJacketGroup: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { dealJacketGroup: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
    }

    return complete.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::complete
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:80
* @route '/audits/deal-jackets/{dealJacketGroup}/complete'
*/
complete.post = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: complete.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroyGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:92
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
export const destroyGroup = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyGroup.url(args, options),
    method: 'delete',
})

destroyGroup.definition = {
    methods: ["delete"],
    url: '/audits/deal-jackets/{dealJacketGroup}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroyGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:92
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
destroyGroup.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealJacketGroup: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { dealJacketGroup: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
    }

    return destroyGroup.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::destroyGroup
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:92
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
destroyGroup.delete = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyGroup.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:33
* @route '/audits/deal-jackets'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:33
* @route '/audits/deal-jackets'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:33
* @route '/audits/deal-jackets'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::index
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:33
* @route '/audits/deal-jackets'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:71
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
export const show = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/audits/deal-jackets/{dealJacketGroup}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:71
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.url = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dealJacketGroup: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'uuid' in args) {
        args = { dealJacketGroup: args.uuid }
    }

    if (Array.isArray(args)) {
        args = {
            dealJacketGroup: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dealJacketGroup: typeof args.dealJacketGroup === 'object'
        ? args.dealJacketGroup.uuid
        : args.dealJacketGroup,
    }

    return show.definition.url
            .replace('{dealJacketGroup}', parsedArgs.dealJacketGroup.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:71
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.get = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Audit\DealJacketController::show
* @see app/Http/Controllers/Tenant/Audit/DealJacketController.php:71
* @route '/audits/deal-jackets/{dealJacketGroup}'
*/
show.head = (args: { dealJacketGroup: string | number | { uuid: string | number } } | [dealJacketGroup: string | number | { uuid: string | number } ] | string | number | { uuid: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const DealJacketController = { create, store, edit, update, destroy, startGroup, complete, destroyGroup, index, show }

export default DealJacketController