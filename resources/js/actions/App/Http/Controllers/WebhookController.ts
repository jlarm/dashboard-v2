import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\WebhookController::gophish
* @see app/Http/Controllers/WebhookController.php:14
* @route '/webhooks/gophish'
*/
export const gophish = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: gophish.url(options),
    method: 'post',
})

gophish.definition = {
    methods: ["post"],
    url: '/webhooks/gophish',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\WebhookController::gophish
* @see app/Http/Controllers/WebhookController.php:14
* @route '/webhooks/gophish'
*/
gophish.url = (options?: RouteQueryOptions) => {
    return gophish.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\WebhookController::gophish
* @see app/Http/Controllers/WebhookController.php:14
* @route '/webhooks/gophish'
*/
gophish.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: gophish.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\WebhookController::gophish
* @see app/Http/Controllers/WebhookController.php:14
* @route '/webhooks/gophish'
*/
const gophishForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: gophish.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\WebhookController::gophish
* @see app/Http/Controllers/WebhookController.php:14
* @route '/webhooks/gophish'
*/
gophishForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: gophish.url(options),
    method: 'post',
})

gophish.form = gophishForm

const WebhookController = { gophish }

export default WebhookController