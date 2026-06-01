import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
const index4b87d2df7e3aa853f6720faea796e36c = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'get',
})

index4b87d2df7e3aa853f6720faea796e36c.definition = {
    methods: ["get","head"],
    url: '/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
index4b87d2df7e3aa853f6720faea796e36c.url = (options?: RouteQueryOptions) => {
    return index4b87d2df7e3aa853f6720faea796e36c.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
index4b87d2df7e3aa853f6720faea796e36c.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
index4b87d2df7e3aa853f6720faea796e36c.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
const index4b87d2df7e3aa853f6720faea796e36cForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
index4b87d2df7e3aa853f6720faea796e36cForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings'
*/
index4b87d2df7e3aa853f6720faea796e36cForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index4b87d2df7e3aa853f6720faea796e36c.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index4b87d2df7e3aa853f6720faea796e36c.form = index4b87d2df7e3aa853f6720faea796e36cForm
/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
const index54d96389de2c26c8aa47568d826bdc1a = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index54d96389de2c26c8aa47568d826bdc1a.url(options),
    method: 'get',
})

index54d96389de2c26c8aa47568d826bdc1a.definition = {
    methods: ["get","head"],
    url: '/settings/managers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
index54d96389de2c26c8aa47568d826bdc1a.url = (options?: RouteQueryOptions) => {
    return index54d96389de2c26c8aa47568d826bdc1a.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
index54d96389de2c26c8aa47568d826bdc1a.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index54d96389de2c26c8aa47568d826bdc1a.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
index54d96389de2c26c8aa47568d826bdc1a.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index54d96389de2c26c8aa47568d826bdc1a.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
const index54d96389de2c26c8aa47568d826bdc1aForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index54d96389de2c26c8aa47568d826bdc1a.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
index54d96389de2c26c8aa47568d826bdc1aForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index54d96389de2c26c8aa47568d826bdc1a.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/managers'
*/
index54d96389de2c26c8aa47568d826bdc1aForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index54d96389de2c26c8aa47568d826bdc1a.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index54d96389de2c26c8aa47568d826bdc1a.form = index54d96389de2c26c8aa47568d826bdc1aForm
/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
const index07e4b1e71f7ca89ae125207430bfcbc5 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index07e4b1e71f7ca89ae125207430bfcbc5.url(options),
    method: 'get',
})

index07e4b1e71f7ca89ae125207430bfcbc5.definition = {
    methods: ["get","head"],
    url: '/settings/compliance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
index07e4b1e71f7ca89ae125207430bfcbc5.url = (options?: RouteQueryOptions) => {
    return index07e4b1e71f7ca89ae125207430bfcbc5.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
index07e4b1e71f7ca89ae125207430bfcbc5.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index07e4b1e71f7ca89ae125207430bfcbc5.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
index07e4b1e71f7ca89ae125207430bfcbc5.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index07e4b1e71f7ca89ae125207430bfcbc5.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
const index07e4b1e71f7ca89ae125207430bfcbc5Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index07e4b1e71f7ca89ae125207430bfcbc5.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
index07e4b1e71f7ca89ae125207430bfcbc5Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index07e4b1e71f7ca89ae125207430bfcbc5.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/compliance'
*/
index07e4b1e71f7ca89ae125207430bfcbc5Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index07e4b1e71f7ca89ae125207430bfcbc5.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index07e4b1e71f7ca89ae125207430bfcbc5.form = index07e4b1e71f7ca89ae125207430bfcbc5Form
/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
const index9b68a843959ff354cb034cafed1e1a3b = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index9b68a843959ff354cb034cafed1e1a3b.url(options),
    method: 'get',
})

index9b68a843959ff354cb034cafed1e1a3b.definition = {
    methods: ["get","head"],
    url: '/settings/reset-courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
index9b68a843959ff354cb034cafed1e1a3b.url = (options?: RouteQueryOptions) => {
    return index9b68a843959ff354cb034cafed1e1a3b.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
index9b68a843959ff354cb034cafed1e1a3b.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index9b68a843959ff354cb034cafed1e1a3b.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
index9b68a843959ff354cb034cafed1e1a3b.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index9b68a843959ff354cb034cafed1e1a3b.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
const index9b68a843959ff354cb034cafed1e1a3bForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index9b68a843959ff354cb034cafed1e1a3b.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
index9b68a843959ff354cb034cafed1e1a3bForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index9b68a843959ff354cb034cafed1e1a3b.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:50
* @route '/settings/reset-courses'
*/
index9b68a843959ff354cb034cafed1e1a3bForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index9b68a843959ff354cb034cafed1e1a3b.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index9b68a843959ff354cb034cafed1e1a3b.form = index9b68a843959ff354cb034cafed1e1a3bForm

/**
* Multiple routes resolve to \App\Http\Controllers\Tenant\Settings\StoreSettingsController::index, so this export is a
* dictionary keyed by URI rather than a callable. Call a specific route with `index['<uri>'](...)`,
* or import the route by name from your generated `routes/` directory.
*/
export const index = {
    '/settings': index4b87d2df7e3aa853f6720faea796e36c,
    '/settings/managers': index54d96389de2c26c8aa47568d826bdc1a,
    '/settings/compliance': index07e4b1e71f7ca89ae125207430bfcbc5,
    '/settings/reset-courses': index9b68a843959ff354cb034cafed1e1a3b,
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateGeneral
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:105
* @route '/settings/general/{store}'
*/
export const updateGeneral = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateGeneral.url(args, options),
    method: 'patch',
})

updateGeneral.definition = {
    methods: ["patch"],
    url: '/settings/general/{store}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateGeneral
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:105
* @route '/settings/general/{store}'
*/
updateGeneral.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return updateGeneral.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateGeneral
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:105
* @route '/settings/general/{store}'
*/
updateGeneral.patch = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateGeneral.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateGeneral
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:105
* @route '/settings/general/{store}'
*/
const updateGeneralForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateGeneral.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateGeneral
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:105
* @route '/settings/general/{store}'
*/
updateGeneralForm.patch = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateGeneral.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateGeneral.form = updateGeneralForm

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateManagers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:123
* @route '/settings/managers/{store}'
*/
export const updateManagers = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateManagers.url(args, options),
    method: 'patch',
})

updateManagers.definition = {
    methods: ["patch"],
    url: '/settings/managers/{store}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateManagers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:123
* @route '/settings/managers/{store}'
*/
updateManagers.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return updateManagers.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateManagers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:123
* @route '/settings/managers/{store}'
*/
updateManagers.patch = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateManagers.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateManagers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:123
* @route '/settings/managers/{store}'
*/
const updateManagersForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateManagers.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateManagers
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:123
* @route '/settings/managers/{store}'
*/
updateManagersForm.patch = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateManagers.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateManagers.form = updateManagersForm

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:141
* @route '/settings/compliance/{store}'
*/
export const updateCompliance = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateCompliance.url(args, options),
    method: 'patch',
})

updateCompliance.definition = {
    methods: ["patch"],
    url: '/settings/compliance/{store}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:141
* @route '/settings/compliance/{store}'
*/
updateCompliance.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return updateCompliance.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:141
* @route '/settings/compliance/{store}'
*/
updateCompliance.patch = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateCompliance.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:141
* @route '/settings/compliance/{store}'
*/
const updateComplianceForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateCompliance.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::updateCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:141
* @route '/settings/compliance/{store}'
*/
updateComplianceForm.patch = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: updateCompliance.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

updateCompliance.form = updateComplianceForm

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::downloadCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:179
* @route '/settings/compliance/{store}/download'
*/
export const downloadCompliance = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadCompliance.url(args, options),
    method: 'get',
})

downloadCompliance.definition = {
    methods: ["get","head"],
    url: '/settings/compliance/{store}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::downloadCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:179
* @route '/settings/compliance/{store}/download'
*/
downloadCompliance.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return downloadCompliance.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::downloadCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:179
* @route '/settings/compliance/{store}/download'
*/
downloadCompliance.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadCompliance.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::downloadCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:179
* @route '/settings/compliance/{store}/download'
*/
downloadCompliance.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: downloadCompliance.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::downloadCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:179
* @route '/settings/compliance/{store}/download'
*/
const downloadComplianceForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadCompliance.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::downloadCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:179
* @route '/settings/compliance/{store}/download'
*/
downloadComplianceForm.get = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadCompliance.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::downloadCompliance
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:179
* @route '/settings/compliance/{store}/download'
*/
downloadComplianceForm.head = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: downloadCompliance.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

downloadCompliance.form = downloadComplianceForm

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::sendComplianceFormLink
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:186
* @route '/settings/compliance/{store}/send-email'
*/
export const sendComplianceFormLink = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendComplianceFormLink.url(args, options),
    method: 'post',
})

sendComplianceFormLink.definition = {
    methods: ["post"],
    url: '/settings/compliance/{store}/send-email',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::sendComplianceFormLink
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:186
* @route '/settings/compliance/{store}/send-email'
*/
sendComplianceFormLink.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return sendComplianceFormLink.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::sendComplianceFormLink
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:186
* @route '/settings/compliance/{store}/send-email'
*/
sendComplianceFormLink.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendComplianceFormLink.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::sendComplianceFormLink
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:186
* @route '/settings/compliance/{store}/send-email'
*/
const sendComplianceFormLinkForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: sendComplianceFormLink.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::sendComplianceFormLink
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:186
* @route '/settings/compliance/{store}/send-email'
*/
sendComplianceFormLinkForm.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: sendComplianceFormLink.url(args, options),
    method: 'post',
})

sendComplianceFormLink.form = sendComplianceFormLinkForm

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:159
* @route '/settings/reset-courses/{store}'
*/
export const resetCourses = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resetCourses.url(args, options),
    method: 'post',
})

resetCourses.definition = {
    methods: ["post"],
    url: '/settings/reset-courses/{store}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:159
* @route '/settings/reset-courses/{store}'
*/
resetCourses.url = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { store: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { store: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            store: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        store: typeof args.store === 'object'
        ? args.store.id
        : args.store,
    }

    return resetCourses.definition.url
            .replace('{store}', parsedArgs.store.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:159
* @route '/settings/reset-courses/{store}'
*/
resetCourses.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resetCourses.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:159
* @route '/settings/reset-courses/{store}'
*/
const resetCoursesForm = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: resetCourses.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Tenant\Settings\StoreSettingsController::resetCourses
* @see app/Http/Controllers/Tenant/Settings/StoreSettingsController.php:159
* @route '/settings/reset-courses/{store}'
*/
resetCoursesForm.post = (args: { store: string | number | { id: string | number } } | [store: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: resetCourses.url(args, options),
    method: 'post',
})

resetCourses.form = resetCoursesForm

const StoreSettingsController = { index, updateGeneral, updateManagers, updateCompliance, downloadCompliance, sendComplianceFormLink, resetCourses }

export default StoreSettingsController