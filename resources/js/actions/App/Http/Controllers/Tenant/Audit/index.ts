import DealJacketController from './DealJacketController'
import DealJacketGroupController from './DealJacketGroupController'
import DealJacketReportDownloadController from './DealJacketReportDownloadController'

const Audit = {
    DealJacketController: Object.assign(DealJacketController, DealJacketController),
    DealJacketGroupController: Object.assign(DealJacketGroupController, DealJacketGroupController),
    DealJacketReportDownloadController: Object.assign(DealJacketReportDownloadController, DealJacketReportDownloadController),
}

export default Audit