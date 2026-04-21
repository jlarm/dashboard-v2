import UserInviteRegistrationController from './UserInviteRegistrationController'
import ContractReviewController from './ContractReviewController'
import DashboardController from './DashboardController'
import DealershipController from './DealershipController'
import CourseController from './CourseController'
import VideoProgressController from './VideoProgressController'
import CourseResultController from './CourseResultController'
import DocumentController from './DocumentController'
import SharedDocumentController from './SharedDocumentController'
import ContractController from './ContractController'
import ContractSendController from './ContractSendController'
import ContractPdfController from './ContractPdfController'
import ViolationStatementController from './ViolationStatementController'
import UserController from './UserController'
import InviteController from './InviteController'

const Central = {
    UserInviteRegistrationController: Object.assign(UserInviteRegistrationController, UserInviteRegistrationController),
    ContractReviewController: Object.assign(ContractReviewController, ContractReviewController),
    DashboardController: Object.assign(DashboardController, DashboardController),
    DealershipController: Object.assign(DealershipController, DealershipController),
    CourseController: Object.assign(CourseController, CourseController),
    VideoProgressController: Object.assign(VideoProgressController, VideoProgressController),
    CourseResultController: Object.assign(CourseResultController, CourseResultController),
    DocumentController: Object.assign(DocumentController, DocumentController),
    SharedDocumentController: Object.assign(SharedDocumentController, SharedDocumentController),
    ContractController: Object.assign(ContractController, ContractController),
    ContractSendController: Object.assign(ContractSendController, ContractSendController),
    ContractPdfController: Object.assign(ContractPdfController, ContractPdfController),
    ViolationStatementController: Object.assign(ViolationStatementController, ViolationStatementController),
    UserController: Object.assign(UserController, UserController),
    InviteController: Object.assign(InviteController, InviteController),
}

export default Central