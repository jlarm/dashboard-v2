import Vendor from './Vendor'
import Settings from './Settings'
import Audit from './Audit'
import Phish from './Phish'
import Ridgeback from './Ridgeback'
import Log from './Log'
import Manual from './Manual'

const Dealer = {
    Vendor: Object.assign(Vendor, Vendor),
    Settings: Object.assign(Settings, Settings),
    Audit: Object.assign(Audit, Audit),
    Phish: Object.assign(Phish, Phish),
    Ridgeback: Object.assign(Ridgeback, Ridgeback),
    Log: Object.assign(Log, Log),
    Manual: Object.assign(Manual, Manual),
}

export default Dealer