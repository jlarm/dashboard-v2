import Settings from './Settings'
import Audit from './Audit'
import Phish from './Phish'
import Ridgeback from './Ridgeback'
import Manual from './Manual'

const Dealer = {
    Settings: Object.assign(Settings, Settings),
    Audit: Object.assign(Audit, Audit),
    Phish: Object.assign(Phish, Phish),
    Ridgeback: Object.assign(Ridgeback, Ridgeback),
    Manual: Object.assign(Manual, Manual),
}

export default Dealer