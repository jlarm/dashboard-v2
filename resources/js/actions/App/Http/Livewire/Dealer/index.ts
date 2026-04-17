import Vendor from './Vendor'
import Settings from './Settings'
import Audit from './Audit'
import Phish from './Phish'
import Ridgeback from './Ridgeback'
import Log from './Log'
import Employee from './Employee'
import Manual from './Manual'
import Docs from './Docs'

const Dealer = {
    Vendor: Object.assign(Vendor, Vendor),
    Settings: Object.assign(Settings, Settings),
    Audit: Object.assign(Audit, Audit),
    Phish: Object.assign(Phish, Phish),
    Ridgeback: Object.assign(Ridgeback, Ridgeback),
    Log: Object.assign(Log, Log),
    Employee: Object.assign(Employee, Employee),
    Manual: Object.assign(Manual, Manual),
    Docs: Object.assign(Docs, Docs),
}

export default Dealer