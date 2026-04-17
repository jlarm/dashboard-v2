import AuthController from './AuthController'
import MailgunWebhookController from './MailgunWebhookController'

const API = {
    AuthController: Object.assign(AuthController, AuthController),
    MailgunWebhookController: Object.assign(MailgunWebhookController, MailgunWebhookController),
}

export default API