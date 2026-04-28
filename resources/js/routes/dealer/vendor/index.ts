import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
import forms from './forms'
/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:106
* @route '/form'
*/
export const form = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

form.definition = {
    methods: ["get","head"],
    url: '/form',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:106
* @route '/form'
*/
form.url = (options?: RouteQueryOptions) => {
    return form.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:106
* @route '/form'
*/
form.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:106
* @route '/form'
*/
form.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: form.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:106
* @route '/form'
*/
const formForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: form.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:106
* @route '/form'
*/
formForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: form.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:106
* @route '/form'
*/
formForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: form.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

form.form = formForm

/**
* @see \App\Http\Controllers\Dealer\VendorController::submit
* @see app/Http/Controllers/Dealer/VendorController.php:128
* @route '/form'
*/
export const submit = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/form',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::submit
* @see app/Http/Controllers/Dealer/VendorController.php:128
* @route '/form'
*/
submit.url = (options?: RouteQueryOptions) => {
    return submit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::submit
* @see app/Http/Controllers/Dealer/VendorController.php:128
* @route '/form'
*/
submit.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::submit
* @see app/Http/Controllers/Dealer/VendorController.php:128
* @route '/form'
*/
const submitForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: submit.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::submit
* @see app/Http/Controllers/Dealer/VendorController.php:128
* @route '/form'
*/
submitForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: submit.url(options),
    method: 'post',
})

submit.form = submitForm

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:34
* @route '/vendors'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/vendors',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:34
* @route '/vendors'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:34
* @route '/vendors'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:34
* @route '/vendors'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:34
* @route '/vendors'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:34
* @route '/vendors'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:34
* @route '/vendors'
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
* @see \App\Http\Controllers\Dealer\VendorController::store
* @see app/Http/Controllers/Dealer/VendorController.php:76
* @route '/vendors'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/vendors',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::store
* @see app/Http/Controllers/Dealer/VendorController.php:76
* @route '/vendors'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::store
* @see app/Http/Controllers/Dealer/VendorController.php:76
* @route '/vendors'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::store
* @see app/Http/Controllers/Dealer/VendorController.php:76
* @route '/vendors'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::store
* @see app/Http/Controllers/Dealer/VendorController.php:76
* @route '/vendors'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:55
* @route '/vendors/{vendor}'
*/
export const show = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/vendors/{vendor}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:55
* @route '/vendors/{vendor}'
*/
show.url = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { vendor: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { vendor: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            vendor: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        vendor: typeof args.vendor === 'object'
        ? args.vendor.id
        : args.vendor,
    }

    return show.definition.url
            .replace('{vendor}', parsedArgs.vendor.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:55
* @route '/vendors/{vendor}'
*/
show.get = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:55
* @route '/vendors/{vendor}'
*/
show.head = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:55
* @route '/vendors/{vendor}'
*/
const showForm = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:55
* @route '/vendors/{vendor}'
*/
showForm.get = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:55
* @route '/vendors/{vendor}'
*/
showForm.head = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\Dealer\VendorController::destroy
* @see app/Http/Controllers/Dealer/VendorController.php:90
* @route '/vendors/{vendor}'
*/
export const destroy = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/vendors/{vendor}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::destroy
* @see app/Http/Controllers/Dealer/VendorController.php:90
* @route '/vendors/{vendor}'
*/
destroy.url = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { vendor: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { vendor: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            vendor: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        vendor: typeof args.vendor === 'object'
        ? args.vendor.id
        : args.vendor,
    }

    return destroy.definition.url
            .replace('{vendor}', parsedArgs.vendor.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::destroy
* @see app/Http/Controllers/Dealer/VendorController.php:90
* @route '/vendors/{vendor}'
*/
destroy.delete = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::destroy
* @see app/Http/Controllers/Dealer/VendorController.php:90
* @route '/vendors/{vendor}'
*/
const destroyForm = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::destroy
* @see app/Http/Controllers/Dealer/VendorController.php:90
* @route '/vendors/{vendor}'
*/
destroyForm.delete = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const vendor = {
    form: Object.assign(form, form),
    submit: Object.assign(submit, submit),
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    forms: Object.assign(forms, forms),
    show: Object.assign(show, show),
    destroy: Object.assign(destroy, destroy),
}

export default vendor