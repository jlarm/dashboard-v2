import Settings from './Settings'
import Audit from './Audit'
import Phish from './Phish'
import Ridgeback from './Ridgeback'

const Dealer = {
    Settings: Object.assign(Settings, Settings),
    Audit: Object.assign(Audit, Audit),
    Phish: Object.assign(Phish, Phish),
    Ridgeback: Object.assign(Ridgeback, Ridgeback),
}

export default Dealer