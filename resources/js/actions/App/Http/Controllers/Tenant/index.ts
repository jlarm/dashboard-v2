import Auth from './Auth'
import DashboardController from './DashboardController'
import Store from './Store'
import SdsController from './SdsController'
import CourseController from './CourseController'
import Settings from './Settings'
import NotificationsController from './NotificationsController'
import Audit from './Audit'
import LogController from './LogController'
import UserController from './UserController'
import Manuals from './Manuals'
import ScansController from './ScansController'
import CyrismaController from './CyrismaController'
import CyrismaReportController from './CyrismaReportController'
import ScanArchiveController from './ScanArchiveController'
import DealerDocController from './DealerDocController'

const Tenant = {
    Auth: Object.assign(Auth, Auth),
    DashboardController: Object.assign(DashboardController, DashboardController),
    Store: Object.assign(Store, Store),
    SdsController: Object.assign(SdsController, SdsController),
    CourseController: Object.assign(CourseController, CourseController),
    Settings: Object.assign(Settings, Settings),
    NotificationsController: Object.assign(NotificationsController, NotificationsController),
    Audit: Object.assign(Audit, Audit),
    LogController: Object.assign(LogController, LogController),
    UserController: Object.assign(UserController, UserController),
    Manuals: Object.assign(Manuals, Manuals),
    ScansController: Object.assign(ScansController, ScansController),
    CyrismaController: Object.assign(CyrismaController, CyrismaController),
    CyrismaReportController: Object.assign(CyrismaReportController, CyrismaReportController),
    ScanArchiveController: Object.assign(ScanArchiveController, ScanArchiveController),
    DealerDocController: Object.assign(DealerDocController, DealerDocController),
}

export default Tenant