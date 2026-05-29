import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\API\MailgunWebhookController::mailgun
* @see app/Http/Controllers/API/MailgunWebhookController.php:17
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
* @see app/Http/Controllers/API/MailgunWebhookController.php:17
* @route '//dashboard.test/api/webhooks/mailgun'
*/
mailgun.url = (options?: RouteQueryOptions) => {
    return mailgun.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\API\MailgunWebhookController::mailgun
* @see app/Http/Controllers/API/MailgunWebhookController.php:17
* @route '//dashboard.test/api/webhooks/mailgun'
*/
mailgun.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: mailgun.url(options),
    method: 'post',
})

const webhooks = {
    mailgun: Object.assign(mailgun, mailgun),
}

export default webhooks