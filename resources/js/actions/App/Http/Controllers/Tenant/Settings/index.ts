import ProfileController from './ProfileController'
import PasswordController from './PasswordController'
import GlobalSettingsController from './GlobalSettingsController'
import AutomatedReportsController from './AutomatedReportsController'
import StoreSettingsController from './StoreSettingsController'

const Settings = {
    ProfileController: Object.assign(ProfileController, ProfileController),
    PasswordController: Object.assign(PasswordController, PasswordController),
    GlobalSettingsController: Object.assign(GlobalSettingsController, GlobalSettingsController),
    AutomatedReportsController: Object.assign(AutomatedReportsController, AutomatedReportsController),
    StoreSettingsController: Object.assign(StoreSettingsController, StoreSettingsController),
}

export default Settings