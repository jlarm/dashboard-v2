import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\API\MailgunWebhookController::handle
* @see app/Http/Controllers/API/MailgunWebhookController.php:17
* @route '//dashboard.test/api/webhooks/mailgun'
*/
export const handle = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handle.url(options),
    method: 'post',
})

handle.definition = {
    methods: ["post"],
    url: '//dashboard.test/api/webhooks/mailgun',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\API\MailgunWebhookController::handle
* @see app/Http/Controllers/API/MailgunWebhookController.php:17
* @route '//dashboard.test/api/webhooks/mailgun'
*/
handle.url = (options?: RouteQueryOptions) => {
    return handle.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\API\MailgunWebhookController::handle
* @see app/Http/Controllers/API/MailgunWebhookController.php:17
* @route '//dashboard.test/api/webhooks/mailgun'
*/
handle.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handle.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\API\MailgunWebhookController::handle
* @see app/Http/Controllers/API/MailgunWebhookController.php:17
* @route '//dashboard.test/api/webhooks/mailgun'
*/
const handleForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handle.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\API\MailgunWebhookController::handle
* @see app/Http/Controllers/API/MailgunWebhookController.php:17
* @route '//dashboard.test/api/webhooks/mailgun'
*/
handleForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: handle.url(options),
    method: 'post',
})

handle.form = handleForm

const MailgunWebhookController = { handle }

export default MailgunWebhookController