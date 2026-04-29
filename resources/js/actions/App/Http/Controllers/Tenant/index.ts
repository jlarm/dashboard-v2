import Auth from './Auth'
import Store from './Store'
import SdsController from './SdsController'
import Settings from './Settings'
import NotificationsController from './NotificationsController'
import Audit from './Audit'
import LogController from './LogController'
import UserController from './UserController'
import ScansController from './ScansController'
import CyrismaController from './CyrismaController'
import CyrismaReportController from './CyrismaReportController'
import DealerDocController from './DealerDocController'

const Tenant = {
    Auth: Object.assign(Auth, Auth),
    Store: Object.assign(Store, Store),
    SdsController: Object.assign(SdsController, SdsController),
    Settings: Object.assign(Settings, Settings),
    NotificationsController: Object.assign(NotificationsController, NotificationsController),
    Audit: Object.assign(Audit, Audit),
    LogController: Object.assign(LogController, LogController),
    UserController: Object.assign(UserController, UserController),
    ScansController: Object.assign(ScansController, ScansController),
    CyrismaController: Object.assign(CyrismaController, CyrismaController),
    CyrismaReportController: Object.assign(CyrismaReportController, CyrismaReportController),
    DealerDocController: Object.assign(DealerDocController, DealerDocController),
}

export default Tenant