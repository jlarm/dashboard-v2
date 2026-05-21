import ViolationAuditController from './ViolationAuditController'
import IndividualAuditController from './IndividualAuditController'
import DealJacketController from './DealJacketController'
import DealJacketReportDownloadController from './DealJacketReportDownloadController'
import FitTestController from './FitTestController'

const Audit = {
    ViolationAuditController: Object.assign(ViolationAuditController, ViolationAuditController),
    IndividualAuditController: Object.assign(IndividualAuditController, IndividualAuditController),
    DealJacketController: Object.assign(DealJacketController, DealJacketController),
    DealJacketReportDownloadController: Object.assign(DealJacketReportDownloadController, DealJacketReportDownloadController),
    FitTestController: Object.assign(FitTestController, FitTestController),
}

export default Audit