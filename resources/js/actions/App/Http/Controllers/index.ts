import API from './API'
import Central from './Central'
import Auth from './Auth'
import Settings from './Settings'
import Tenant from './Tenant'
import Dealer from './Dealer'

const Controllers = {
    API: Object.assign(API, API),
    Central: Object.assign(Central, Central),
    Auth: Object.assign(Auth, Auth),
    Settings: Object.assign(Settings, Settings),
    Tenant: Object.assign(Tenant, Tenant),
    Dealer: Object.assign(Dealer, Dealer),
}

export default Controllers