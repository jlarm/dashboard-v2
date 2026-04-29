import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Dealer\VendorController::download
* @see app/Http/Controllers/Dealer/VendorController.php:97
* @route '/vendors/forms/{vendorForm}/download'
*/
export const download = (args: { vendorForm: string | number | { id: string | number } } | [vendorForm: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/vendors/forms/{vendorForm}/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::download
* @see app/Http/Controllers/Dealer/VendorController.php:97
* @route '/vendors/forms/{vendorForm}/download'
*/
download.url = (args: { vendorForm: string | number | { id: string | number } } | [vendorForm: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return download.definition.url
            .replace('{vendorForm}', parsedArgs.vendorForm.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::download
* @see app/Http/Controllers/Dealer/VendorController.php:97
* @route '/vendors/forms/{vendorForm}/download'
*/
download.get = (args: { vendorForm: string | number | { id: string | number } } | [vendorForm: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::download
* @see app/Http/Controllers/Dealer/VendorController.php:97
* @route '/vendors/forms/{vendorForm}/download'
*/
download.head = (args: { vendorForm: string | number | { id: string | number } } | [vendorForm: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Dealer\VendorController::send
* @see app/Http/Controllers/Dealer/VendorController.php:81
* @route '/vendors/{vendor}/forms'
*/
export const send = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(args, options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/vendors/{vendor}/forms',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Dealer\VendorController::send
* @see app/Http/Controllers/Dealer/VendorController.php:81
* @route '/vendors/{vendor}/forms'
*/
send.url = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return send.definition.url
            .replace('{vendor}', parsedArgs.vendor.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Dealer\VendorController::send
* @see app/Http/Controllers/Dealer/VendorController.php:81
* @route '/vendors/{vendor}/forms'
*/
send.post = (args: { vendor: string | number | { id: string | number } } | [vendor: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(args, options),
    method: 'post',
})

const forms = {
    download: Object.assign(download, download),
    send: Object.assign(send, send),
}

export default forms