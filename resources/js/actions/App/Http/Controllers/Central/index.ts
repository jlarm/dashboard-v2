import UserInviteRegistrationController from './UserInviteRegistrationController'
import DashboardController from './DashboardController'
import DealershipController from './DealershipController'
import CourseController from './CourseController'
import VideoProgressController from './VideoProgressController'
import CourseResultController from './CourseResultController'
import DocumentController from './DocumentController'
import UserController from './UserController'
import InviteController from './InviteController'

const Central = {
    UserInviteRegistrationController: Object.assign(UserInviteRegistrationController, UserInviteRegistrationController),
    DashboardController: Object.assign(DashboardController, DashboardController),
    DealershipController: Object.assign(DealershipController, DealershipController),
    CourseController: Object.assign(CourseController, CourseController),
    VideoProgressController: Object.assign(VideoProgressController, VideoProgressController),
    CourseResultController: Object.assign(CourseResultController, CourseResultController),
    DocumentController: Object.assign(DocumentController, DocumentController),
    UserController: Object.assign(UserController, UserController),
    InviteController: Object.assign(InviteController, InviteController),
}

export default Central