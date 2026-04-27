import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
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

const WebhookController = { gophish }

export default WebhookController