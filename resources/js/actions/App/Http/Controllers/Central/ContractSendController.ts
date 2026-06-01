import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Central\ContractSendController::review
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard-v2.test/contracts/{contract}/send'
*/
export const review = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: review.url(args, options),
    method: 'post',
})

review.definition = {
    methods: ["post"],
    url: '//dashboard-v2.test/contracts/{contract}/send',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ContractSendController::review
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard-v2.test/contracts/{contract}/send'
*/
review.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
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

    return review.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractSendController::review
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard-v2.test/contracts/{contract}/send'
*/
review.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: review.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractSendController::review
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard-v2.test/contracts/{contract}/send'
*/
const reviewForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: review.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractSendController::review
* @see app/Http/Controllers/Central/ContractSendController.php:18
* @route '//dashboard-v2.test/contracts/{contract}/send'
*/
reviewForm.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: review.url(args, options),
    method: 'post',
})

review.form = reviewForm

/**
* @see \App\Http\Controllers\Central\ContractSendController::pdf
* @see app/Http/Controllers/Central/ContractSendController.php:28
* @route '//dashboard-v2.test/contracts/{contract}/pdf/send'
*/
export const pdf = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pdf.url(args, options),
    method: 'post',
})

pdf.definition = {
    methods: ["post"],
    url: '//dashboard-v2.test/contracts/{contract}/pdf/send',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Central\ContractSendController::pdf
* @see app/Http/Controllers/Central/ContractSendController.php:28
* @route '//dashboard-v2.test/contracts/{contract}/pdf/send'
*/
pdf.url = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions) => {
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

    return pdf.definition.url
            .replace('{contract}', parsedArgs.contract.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Central\ContractSendController::pdf
* @see app/Http/Controllers/Central/ContractSendController.php:28
* @route '//dashboard-v2.test/contracts/{contract}/pdf/send'
*/
pdf.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pdf.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractSendController::pdf
* @see app/Http/Controllers/Central/ContractSendController.php:28
* @route '//dashboard-v2.test/contracts/{contract}/pdf/send'
*/
const pdfForm = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: pdf.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Central\ContractSendController::pdf
* @see app/Http/Controllers/Central/ContractSendController.php:28
* @route '//dashboard-v2.test/contracts/{contract}/pdf/send'
*/
pdfForm.post = (args: { contract: string | { uuid: string } } | [contract: string | { uuid: string } ] | string | { uuid: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: pdf.url(args, options),
    method: 'post',
})

pdf.form = pdfForm

const ContractSendController = { review, pdf }

export default ContractSendController