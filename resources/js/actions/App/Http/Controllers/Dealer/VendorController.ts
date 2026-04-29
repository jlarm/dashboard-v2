import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:104
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
* @see app/Http/Controllers/Dealer/VendorController.php:104
* @route '/form'
*/
form.url = (options?: RouteQueryOptions) => {
    return form.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:104
* @route '/form'
*/
form.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::form
* @see app/Http/Controllers/Dealer/VendorController.php:104
* @route '/form'
*/
form.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: form.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::submit
* @see app/Http/Controllers/Dealer/VendorController.php:126
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
* @see app/Http/Controllers/Dealer/VendorController.php:126
* @route '/form'
*/
submit.url = (options?: RouteQueryOptions) => {
    return submit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::submit
* @see app/Http/Controllers/Dealer/VendorController.php:126
* @route '/form'
*/
submit.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
export const thankyou = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thankyou.url(options),
    method: 'get',
})

thankyou.definition = {
    methods: ["get","head"],
    url: '/vendors/thankyou',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
thankyou.url = (options?: RouteQueryOptions) => {
    return thankyou.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
thankyou.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thankyou.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::thankyou
* @see app/Http/Controllers/Dealer/VendorController.php:139
* @route '/vendors/thankyou'
*/
thankyou.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: thankyou.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:35
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
* @see app/Http/Controllers/Dealer/VendorController.php:35
* @route '/vendors'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:35
* @route '/vendors'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::index
* @see app/Http/Controllers/Dealer/VendorController.php:35
* @route '/vendors'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::store
* @see app/Http/Controllers/Dealer/VendorController.php:74
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
* @see app/Http/Controllers/Dealer/VendorController.php:74
* @route '/vendors'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::store
* @see app/Http/Controllers/Dealer/VendorController.php:74
* @route '/vendors'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::downloadForm
* @see app/Http/Controllers/Dealer/VendorController.php:97
* @route '/vendors/forms/{vendorForm}/download'
*/
export const downloadForm = (args: { vendorForm: string | number | { id: string | number } } | [vendorForm: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadForm.url(args, options),
    method: 'get',
})

downloadForm.definition = {
    methods: ["get","head"],
    url: '/vendors/forms/{vendorForm}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::downloadForm
* @see app/Http/Controllers/Dealer/VendorController.php:97
* @route '/vendors/forms/{vendorForm}/download'
*/
downloadForm.url = (args: { vendorForm: string | number | { id: string | number } } | [vendorForm: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { vendorForm: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { vendorForm: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            vendorForm: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        vendorForm: typeof args.vendorForm === 'object'
        ? args.vendorForm.id
        : args.vendorForm,
    }

    return downloadForm.definition.url
            .replace('{vendorForm}', parsedArgs.vendorForm.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::downloadForm
* @see app/Http/Controllers/Dealer/VendorController.php:97
* @route '/vendors/forms/{vendorForm}/download'
*/
downloadForm.get = (args: { vendorForm: string | number | { id: string | number } } | [vendorForm: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: downloadForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::downloadForm
* @see app/Http/Controllers/Dealer/VendorController.php:97
* @route '/vendors/forms/{vendorForm}/download'
*/
downloadForm.head = (args: { vendorForm: string | number | { id: string | number } } | [vendorForm: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: downloadForm.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:53
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
* @see app/Http/Controllers/Dealer/VendorController.php:53
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
* @see app/Http/Controllers/Dealer/VendorController.php:53
* @route '/vendors/{vendor}'
*/
show.get = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::show
* @see app/Http/Controllers/Dealer/VendorController.php:53
* @route '/vendors/{vendor}'
*/
show.head = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::sendForm
* @see app/Http/Controllers/Dealer/VendorController.php:81
* @route '/vendors/{vendor}/forms'
*/
export const sendForm = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendForm.url(args, options),
    method: 'post',
})

sendForm.definition = {
    methods: ["post"],
    url: '/vendors/{vendor}/forms',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::sendForm
* @see app/Http/Controllers/Dealer/VendorController.php:81
* @route '/vendors/{vendor}/forms'
*/
sendForm.url = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return sendForm.definition.url
            .replace('{vendor}', parsedArgs.vendor.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::sendForm
* @see app/Http/Controllers/Dealer/VendorController.php:81
* @route '/vendors/{vendor}/forms'
*/
sendForm.post = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendForm.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::destroy
* @see app/Http/Controllers/Dealer/VendorController.php:88
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
* @see app/Http/Controllers/Dealer/VendorController.php:88
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
* @see app/Http/Controllers/Dealer/VendorController.php:88
* @route '/vendors/{vendor}'
*/
destroy.delete = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const VendorController = { form, submit, thankyou, index, store, downloadForm, show, sendForm, destroy }

export default VendorController