import IspController from './IspController'
import OshaController from './OshaController'
import RedFlagController from './RedFlagController'
import CmsController from './CmsController'

const Manuals = {
    IspController: Object.assign(IspController, IspController),
    OshaController: Object.assign(OshaController, OshaController),
    RedFlagController: Object.assign(RedFlagController, RedFlagController),
    CmsController: Object.assign(CmsController, CmsController),
}

export default Manuals