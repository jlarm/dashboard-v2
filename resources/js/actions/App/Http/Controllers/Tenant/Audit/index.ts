import ViolationAuditController from './ViolationAuditController'
import IndividualAuditController from './IndividualAuditController'
import DealJacketController from './DealJacketController'
import DealJacketReportDownloadController from './DealJacketReportDownloadController'

const Audit = {
    ViolationAuditController: Object.assign(ViolationAuditController, ViolationAuditController),
    IndividualAuditController: Object.assign(IndividualAuditController, IndividualAuditController),
    DealJacketController: Object.assign(DealJacketController, DealJacketController),
    DealJacketReportDownloadController: Object.assign(DealJacketReportDownloadController, DealJacketReportDownloadController),
}

export default Audit