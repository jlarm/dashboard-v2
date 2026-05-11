import ViolationAuditController from './ViolationAuditController'
import IndividualAuditController from './IndividualAuditController'
import DealJacketController from './DealJacketController'
import DealJacketGroupController from './DealJacketGroupController'
import DealJacketReportDownloadController from './DealJacketReportDownloadController'

const Audit = {
    ViolationAuditController: Object.assign(ViolationAuditController, ViolationAuditController),
    IndividualAuditController: Object.assign(IndividualAuditController, IndividualAuditController),
    DealJacketController: Object.assign(DealJacketController, DealJacketController),
    DealJacketGroupController: Object.assign(DealJacketGroupController, DealJacketGroupController),
    DealJacketReportDownloadController: Object.assign(DealJacketReportDownloadController, DealJacketReportDownloadController),
}

export default Audit