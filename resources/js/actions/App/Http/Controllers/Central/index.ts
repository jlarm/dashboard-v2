import UserInviteRegistrationController from './UserInviteRegistrationController'
import DashboardController from './DashboardController'
import UserController from './UserController'
import InviteController from './InviteController'

const Central = {
    UserInviteRegistrationController: Object.assign(UserInviteRegistrationController, UserInviteRegistrationController),
    DashboardController: Object.assign(DashboardController, DashboardController),
    UserController: Object.assign(UserController, UserController),
    InviteController: Object.assign(InviteController, InviteController),
}

export default Central