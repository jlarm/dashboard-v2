import Settings from './Settings'
import Phish from './Phish'
import Ridgeback from './Ridgeback'

const Dealer = {
    Settings: Object.assign(Settings, Settings),
    Phish: Object.assign(Phish, Phish),
    Ridgeback: Object.assign(Ridgeback, Ridgeback),
}

export default Dealer