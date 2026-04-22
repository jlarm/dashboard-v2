import Auth from './Auth'
import Store from './Store'
import SdsController from './SdsController'
import Settings from './Settings'
import Audit from './Audit'
import CyrismaController from './CyrismaController'
import CyrismaReportController from './CyrismaReportController'

const Tenant = {
    Auth: Object.assign(Auth, Auth),
    Store: Object.assign(Store, Store),
    SdsController: Object.assign(SdsController, SdsController),
    Settings: Object.assign(Settings, Settings),
    Audit: Object.assign(Audit, Audit),
    CyrismaController: Object.assign(CyrismaController, CyrismaController),
    CyrismaReportController: Object.assign(CyrismaReportController, CyrismaReportController),
}

export default Tenant