import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\ContractPdfController::generate
* @see app/Http/Controllers/Central/ContractPdfController.php:16
* @route '//dashboard.test/contracts/{contract}/pdf'
*/
export const generate = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

generate.definition = {
    methods: ["post"],
    url: '//dashboard.test/contracts/{contract}/pdf',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ContractPdfController::generate
* @see app/Http/Controllers/Central/ContractPdfController.php:16
* @route '//dashboard.test/contracts/{contract}/pdf'
*/
generate.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
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

    return generate.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractPdfController::generate
* @see app/Http/Controllers/Central/ContractPdfController.php:16
* @route '//dashboard.test/contracts/{contract}/pdf'
*/
generate.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractPdfController::download
* @see app/Http/Controllers/Central/ContractPdfController.php:25
* @route '//dashboard.test/contracts/{contract}/pdf'
*/
export const download = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '//dashboard.test/contracts/{contract}/pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Central\ContractPdfController::download
* @see app/Http/Controllers/Central/ContractPdfController.php:25
* @route '//dashboard.test/contracts/{contract}/pdf'
*/
download.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
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

    return download.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractPdfController::download
* @see app/Http/Controllers/Central/ContractPdfController.php:25
* @route '//dashboard.test/contracts/{contract}/pdf'
*/
download.get = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Central\ContractPdfController::download
* @see app/Http/Controllers/Central/ContractPdfController.php:25
* @route '//dashboard.test/contracts/{contract}/pdf'
*/
download.head = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Central\ContractSendController::send
* @see app/Http/Controllers/Central/ContractSendController.php:28
* @route '//dashboard.test/contracts/{contract}/pdf/send'
*/
export const send = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(args, options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '//dashboard.test/contracts/{contract}/pdf/send',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ContractSendController::send
* @see app/Http/Controllers/Central/ContractSendController.php:28
* @route '//dashboard.test/contracts/{contract}/pdf/send'
*/
send.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
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

    return send.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractSendController::send
* @see app/Http/Controllers/Central/ContractSendController.php:28
* @route '//dashboard.test/contracts/{contract}/pdf/send'
*/
send.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(args, options),
    method: 'post',
})

const pdf = {
    generate: Object.assign(generate, generate),
    download: Object.assign(download, download),
    send: Object.assign(send, send),
}

export default pdf