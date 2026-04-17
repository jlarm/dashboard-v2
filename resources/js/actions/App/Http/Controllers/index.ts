import API from './API'
import Central from './Central'
import Auth from './Auth'
import Settings from './Settings'
import OshaPdfTestController from './OshaPdfTestController'
import DealJacketPdfTestController from './DealJacketPdfTestController'
import DealJacketReportPdfTestController from './DealJacketReportPdfTestController'
import GlbaPdfTestController from './GlbaPdfTestController'
import BodyShopPdfTestController from './BodyShopPdfTestController'
import Dealer from './Dealer'
import Tenant from './Tenant'
import WebhookController from './WebhookController'

const Controllers = {
    API: Object.assign(API, API),
    Central: Object.assign(Central, Central),
    Auth: Object.assign(Auth, Auth),
    Settings: Object.assign(Settings, Settings),
    OshaPdfTestController: Object.assign(OshaPdfTestController, OshaPdfTestController),
    DealJacketPdfTestController: Object.assign(DealJacketPdfTestController, DealJacketPdfTestController),
    DealJacketReportPdfTestController: Object.assign(DealJacketReportPdfTestController, DealJacketReportPdfTestController),
    GlbaPdfTestController: Object.assign(GlbaPdfTestController, GlbaPdfTestController),
    BodyShopPdfTestController: Object.assign(BodyShopPdfTestController, BodyShopPdfTestController),
    Dealer: Object.assign(Dealer, Dealer),
    Tenant: Object.assign(Tenant, Tenant),
    WebhookController: Object.assign(WebhookController, WebhookController),
}

export default Controllers