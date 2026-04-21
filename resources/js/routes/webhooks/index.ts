import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\API\MailgunWebhookController::mailgun
* @see app/Http/Controllers/API/MailgunWebhookController.php:18
* @route '//dashboard.test/api/webhooks/mailgun'
*/
export const mailgun = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: mailgun.url(options),
    method: 'post',
})

mailgun.definition = {
    methods: ["post"],
    url: '//dashboard.test/api/webhooks/mailgun',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\API\MailgunWebhookController::mailgun
* @see app/Http/Controllers/API/MailgunWebhookController.php:18
* @route '//dashboard.test/api/webhooks/mailgun'
*/
mailgun.url = (options?: RouteQueryOptions) => {
    return mailgun.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\API\MailgunWebhookController::mailgun
* @see app/Http/Controllers/API/MailgunWebhookController.php:18
* @route '//dashboard.test/api/webhooks/mailgun'
*/
mailgun.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: mailgun.url(options),
    method: 'post',
})

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

const webhooks = {
    mailgun: Object.assign(mailgun, mailgun),
    gophish: Object.assign(gophish, gophish),
}

export default webhooks