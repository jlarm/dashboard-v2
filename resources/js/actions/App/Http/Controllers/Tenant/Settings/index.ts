import ProfileController from './ProfileController'
import PasswordController from './PasswordController'
import AutomatedReportsController from './AutomatedReportsController'

const Settings = {
    ProfileController: Object.assign(ProfileController, ProfileController),
    PasswordController: Object.assign(PasswordController, PasswordController),
    AutomatedReportsController: Object.assign(AutomatedReportsController, AutomatedReportsController),
}

export default Settings