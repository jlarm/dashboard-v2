import Auth from './Auth'
import SdsController from './SdsController'
import Audit from './Audit'
import CyrismaController from './CyrismaController'
import CyrismaReportController from './CyrismaReportController'

const Tenant = {
    Auth: Object.assign(Auth, Auth),
    SdsController: Object.assign(SdsController, SdsController),
    Audit: Object.assign(Audit, Audit),
    CyrismaController: Object.assign(CyrismaController, CyrismaController),
    CyrismaReportController: Object.assign(CyrismaReportController, CyrismaReportController),
}

export default Tenant